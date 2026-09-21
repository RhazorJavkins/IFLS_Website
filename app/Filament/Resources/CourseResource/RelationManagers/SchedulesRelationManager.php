<?php

namespace App\Filament\Resources\CourseResource\RelationManagers;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SchedulesRelationManager extends RelationManager
{
    protected static string $relationship = 'schedules';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('type')->label('Tipe')->options([
                'online' => 'Online',
                'offline' => 'Offline',
            ])->required()->default('online'),
            TextInput::make('day')->label('Hari')->required()->maxLength(20),
            TimePicker::make('start_time')->label('Mulai')->required(),
            TimePicker::make('end_time')->label('Selesai')->required(),
            TextInput::make('instructor')->label('Pengajar')->required()->maxLength(120),
            TextInput::make('room')->label('Ruang (offline)')->maxLength(50),
            TextInput::make('quota')->label('Kuota')->numeric()->minValue(1)->default(10),
            Toggle::make('is_full')->label('Kuota Penuh'),
        ])->columns(2);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('day')
            ->columns([
                TextColumn::make('type')->badge()->color(fn ($state) => $state === 'online' ? 'info' : 'success'),
                TextColumn::make('day')->label('Hari')->weight('bold'),
                TextColumn::make('start_time')->label('Mulai')->time('H:i'),
                TextColumn::make('end_time')->label('Selesai')->time('H:i'),
                TextColumn::make('instructor')->label('Pengajar'),
                TextColumn::make('room')->label('Ruang')->placeholder('—'),
                TextColumn::make('quota')->label('Kuota'),
                IconColumn::make('is_full')->label('Penuh')->boolean(),
            ])
            ->filters([])
            ->headerActions([
                \Filament\Actions\CreateAction::make(),
            ])
            ->actions([
                \Filament\Actions\EditAction::make(),
                \Filament\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
