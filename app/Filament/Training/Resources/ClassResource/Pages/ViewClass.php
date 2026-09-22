<?php

namespace App\Filament\Training\Resources\ClassResource\Pages;

use App\Filament\Training\Resources\ClassResource;
use App\Models\ClassSession;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\ViewRecord;

class ViewClass extends ViewRecord
{
    protected static string $resource = ClassResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('addSession')
                ->label('Pertemuan Baru')
                ->icon('heroicon-o-plus-circle')
                ->form([
                    DatePicker::make('session_date')->label('Tanggal')->required()->default(now()),
                    TextInput::make('sequence')
                        ->label('Pertemuan ke-')
                        ->numeric()
                        ->required()
                        ->default(fn () => ClassSession::where('school_class_id', $this->getRecord()->id)->max('sequence') + 1),
                    Textarea::make('material')->label('Materi')->rows(2)->maxLength(500),
                ])
                ->action(function (array $data): void {
                    ClassSession::create([
                        'school_class_id' => $this->getRecord()->id,
                        'session_date' => $data['session_date'],
                        'sequence' => (int) $data['sequence'],
                        'material' => $data['material'] ?? null,
                    ]);
                }),
            Action::make('attendance')
                ->label('Absensi')
                ->icon('heroicon-m-check-badge')
                ->url(fn () => static::getResource()::getUrl('attendance', ['record' => $this->getRecord()])),
            Action::make('grades')
                ->label('Nilai')
                ->icon('heroicon-m-academic-cap')
                ->url(fn () => static::getResource()::getUrl('grades', ['record' => $this->getRecord()])),
            Action::make('report')
                ->label('Laporan')
                ->icon('heroicon-m-document-chart-bar')
                ->url(fn () => static::getResource()::getUrl('report', ['record' => $this->getRecord()])),
            \Filament\Actions\EditAction::make(),
        ];
    }
}
