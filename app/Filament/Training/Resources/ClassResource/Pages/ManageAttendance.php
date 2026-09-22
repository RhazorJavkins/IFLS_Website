<?php

namespace App\Filament\Training\Resources\ClassResource\Pages;

use App\Filament\Training\Resources\ClassResource;
use App\Models\Attendance;
use App\Models\ClassSession;
use App\Models\SchoolClass;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Resources\Pages\Page;
use Filament\Schemas\Schema;
use Livewire\Attributes\Url;

/**
 * Absensi bulk: pilih pertemuan → satu form dengan toggle status per murid.
 * Satu-satu-form (bukan satu-baris) agar tetap 1 form per halaman (Laravel rule).
 */
class ManageAttendance extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string $resource = ClassResource::class;

    protected string $view = 'filament.training.pages.manage-attendance';

    protected static ?string $slug = 'attendance';

    public SchoolClass $record;

    /** ID pertemuan yang sedang diedit (bound langsung ke <select wire:model.live>). */
    #[Url(as: 'sesi')]
    public ?int $sessionId = null;

    /** [student_id => status] yang sedang diedit di form. */
    public array $status = [];

    public array $addSessionData = [];

    public function getRecord(): SchoolClass
    {
        return $this->record;
    }

    public function mount(): void
    {
        $record = request()->route('record');

        if (! $record instanceof SchoolClass) {
            abort(404);
        }

        $teacherId = auth()->user()?->isTeacher() ? auth()->id() : null;

        if ($teacherId && $record->teacher_id !== $teacherId) {
            abort(404);
        }

        $this->record = $record;
        $this->sessionId ??= $this->record->sessions()->orderByDesc('session_date')->first()?->id;

        $this->loadStatuses();
    }

    /** Form "tambah pertemuan" — konvensi Filament v4: method bernama sesuai form. */
    public function addSessionForm(Schema $schema): Schema
    {
        return $schema
            ->columns(4)
            ->components([
                DatePicker::make('session_date')->label('Tanggal')->required()->default(now()),
                TextInput::make('sequence')
                    ->label('Pertemuan ke-')
                    ->numeric()
                    ->required()
                    ->default(fn () => $this->record->sessions()->max('sequence') + 1),
                Textarea::make('material')->label('Materi')->rows(1)->maxLength(500)->columnSpan(2),
            ])
            ->statePath('addSessionData');
    }

    /** Muat status tersimpan untuk pertemuan terpilih (default: hadir). */
    public function loadStatuses(): void
    {
        if (! $this->sessionId) {
            $this->status = [];

            return;
        }

        $existing = Attendance::where('class_session_id', $this->sessionId)
            ->pluck('status', 'student_id');

        $this->status = $this->record->students
            ->mapWithKeys(fn ($s) => [$s->id => $existing[$s->id] ?? Attendance::STATUS_PRESENT])
            ->all();
    }

    public function save(): void
    {
        foreach ($this->status as $studentId => $value) {
            Attendance::updateOrCreate(
                ['class_session_id' => $this->sessionId, 'student_id' => $studentId],
                ['status' => $value, 'marked_by' => auth()->id()]
            );
        }

        session()->flash('saved', true);
    }

    public function addSession(): void
    {
        $data = $this->addSessionForm->getState();

        $session = ClassSession::create([
            'school_class_id' => $this->record->id,
            'session_date' => $data['session_date'],
            'sequence' => (int) $data['sequence'],
            'material' => $data['material'] ?? null,
        ]);

        $this->sessionId = $session->id;
        $this->loadStatuses();
    }

    protected function getViewData(): array
    {
        return [
            'sessions' => $this->record->sessions()->orderByDesc('session_date')->get(),
            'session' => $this->sessionId ? ClassSession::find($this->sessionId) : null,
            'csvUrl' => route('portal.training.attendance.csv', $this->record),
        ];
    }
}
