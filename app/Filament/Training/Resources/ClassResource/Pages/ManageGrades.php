<?php

namespace App\Filament\Training\Resources\ClassResource\Pages;

use App\Filament\Training\Resources\ClassResource;
use App\Models\Grade;
use App\Models\SchoolClass;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\Page;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;

/**
 * Kelola nilai satu kelas — tabel stand-alone (bukan resource) yang
 * sudah ter-scope ke kelas ini. Guru hanya bisa membuka kelas miliknya.
 */
class ManageGrades extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string $resource = ClassResource::class;

    protected string $view = 'filament.training.pages.manage-grades';

    protected static ?string $slug = 'grades';

    public SchoolClass $record;

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
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Grade::query()->where('school_class_id', $this->record->id))
            ->columns([
                TextColumn::make('student.name')->label('Murid')->sortable(),
                TextColumn::make('type')->label('Jenis')->badge()
                    ->formatStateUsing(fn (string $state) => Grade::TYPES[$state] ?? $state)
                    ->color('info'),
                TextColumn::make('title')->label('Judul')->placeholder('—'),
                TextColumn::make('score')->label('Skor')->alignCenter()->sortable(),
                TextColumn::make('weight')->label('Bobot')->alignCenter(),
                TextColumn::make('graded_at')->label('Tanggal')->date('d M Y')->sortable(),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Tambah Nilai')
                    ->form([
                        Select::make('student_id')->label('Murid')
                            ->options(fn () => $this->record->students()->orderBy('name')->pluck('name', 'id'))
                            ->required(),
                        Select::make('type')->label('Jenis')->options(Grade::TYPES)->required()->default('quiz'),
                        TextInput::make('title')->label('Judul')->maxLength(150)->placeholder('mis. Ujian Tengah Semester'),
                        TextInput::make('score')->label('Skor (0–100)')->numeric()->minValue(0)->maxValue(100)->required(),
                        TextInput::make('weight')->label('Bobot')->numeric()->minValue(0.1)->step(0.1)->default(1)->required(),
                        DatePicker::make('graded_at')->label('Tanggal')->default(now()),
                    ])
                    ->using(function (array $data) {
                        return Grade::create($data + [
                            'school_class_id' => $this->record->id,
                            'created_by' => auth()->id(),
                        ]);
                    }),
            ])
            ->actions([
                DeleteAction::make(),
            ])
            ->defaultSort('student_id');
    }

    protected function getViewData(): array
    {
        return [
            'csvUrl' => route('portal.training.grades.csv', $this->record),
        ];
    }
}
