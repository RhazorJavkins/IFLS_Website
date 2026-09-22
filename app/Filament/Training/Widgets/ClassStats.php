<?php

namespace App\Filament\Training\Widgets;

use App\Models\Attendance;
use App\Models\SchoolClass;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ClassStats extends BaseWidget
{
    protected ?string $heading = 'Ringkasan Mengajar';

    protected function getStats(): array
    {
        $user = auth()->user();

        $classes = SchoolClass::query()
            ->when($user->isTeacher(), fn ($q) => $q->where('teacher_id', $user->id))
            ->where('status', 'active')
            ->get();

        $classIds = $classes->pluck('id');
        $studentCount = \App\Models\Student::whereHas('classes', fn ($q) => $q->whereIn('school_classes.id', $classIds))->count();

        $riskCount = 0;
        foreach ($classes as $class) {
            $riskCount += count($class->atRiskStudents());
        }

        $recentAttendance = Attendance::whereIn('class_session_id', function ($q) use ($classIds) {
            $q->select('id')->from('class_sessions')->whereIn('school_class_id', $classIds);
        })
            ->where('created_at', '>=', now()->subDays(7))
            ->count();

        return [
            Stat::make('Kelas Aktif', $classes->count())
                ->description('Sedang berjalan')
                ->color('primary')
                ->icon('heroicon-o-academic-cap'),
            Stat::make('Total Murid', $studentCount)
                ->description('Di semua kelas aktif')
                ->color('info')
                ->icon('heroicon-o-user-group'),
            Stat::make('Absensi Diisi (7 hari)', $recentAttendance)
                ->description('Entri absensi terakhir')
                ->color('success')
                ->icon('heroicon-m-check-badge'),
            Stat::make('Murid Berisiko', $riskCount)
                ->description($riskCount > 0 ? 'Alpa ≥ 3 atau nilai < 70' : 'Semua aman 👍')
                ->color($riskCount > 0 ? 'danger' : 'success')
                ->icon('heroicon-m-exclamation-triangle'),
        ];
    }
}
