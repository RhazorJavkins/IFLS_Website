<?php

namespace App\Filament\Training\Resources\ClassResource\Pages;

use App\Filament\Training\Resources\ClassResource;
use App\Models\SchoolClass;
use Filament\Resources\Pages\Page;

class ClassReport extends Page
{
    protected static string $resource = ClassResource::class;

    protected string $view = 'filament.training.pages.class-report';

    protected static ?string $slug = 'report';

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

        $this->record = $record->load('students');
    }

    protected function getViewData(): array
    {
        $rows = $this->record->students
            ->map(fn ($student) => [
                'student' => $student,
                'attendance' => $this->record->attendanceRate($student->id),
                'absences' => $this->record->absences($student->id),
                'average' => $this->record->weightedAverage($student->id),
                'wa' => $student->phone
                    ? 'https://wa.me/' . preg_replace('/\D/', '', $student->phone)
                    : null,
            ]);

        return [
            'rows' => $rows,
            'risk' => $this->record->atRiskStudents(),
            'attendanceCsv' => route('portal.training.attendance.csv', $this->record),
            'gradesCsv' => route('portal.training.grades.csv', $this->record),
        ];
    }
}
