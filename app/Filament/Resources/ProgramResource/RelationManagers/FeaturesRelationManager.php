<?php

namespace App\Filament\Resources\ProgramResource\RelationManagers;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class FeaturesRelationManager extends RelationManager
{
    protected static string $relationship = 'features';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('group')->label('Grup Render')->options([
                'level' => 'Level (tab pills)',
                'tier' => 'Tier (stepper)',
                'format' => 'Format (kartu)',
                'service_type' => 'Tipe Layanan (kartu)',
                'highlight' => 'Highlight (kartu tunggal)',
            ])->required()->default('level'),
            TextInput::make('title.id')->label('Judul (Indonesia)')->required()->maxLength(120),
            TextInput::make('title.en')->label('Judul (English)')->required()->maxLength(120),
            TextInput::make('title.zh')->label('Judul (中文)')->required()->maxLength(120),
            Textarea::make('description.id')->label('Deskripsi (Indonesia)')->required()->rows(3)->columnSpanFull(),
            Textarea::make('description.en')->label('Deskripsi (English)')->required()->rows(3)->columnSpanFull(),
            Textarea::make('description.zh')->label('Deskripsi (中文)')->required()->rows(3)->columnSpanFull(),
            TextInput::make('icon')->label('Ikon FontAwesome')->maxLength(50)->placeholder('fa-solid fa-star'),
            TextInput::make('badge')->label('Badge kecil')->maxLength(10)->placeholder('+'),
            TextInput::make('sort')->numeric()->minValue(0)->default(0)->label('Urutan'),
            Toggle::make('is_active')->label('Aktif')->default(true),
        ])->columns(3);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('sort')
            ->columns([
                TextColumn::make('group')->badge()->color('info')->formatStateUsing(fn ($state) => str_replace('_', ' ', $state)),
                TextColumn::make('translated_title')->label('Judul')->searchable(),
                TextColumn::make('icon')->label('Ikon')->toggleable(),
                TextColumn::make('sort')->label('Urutan')->sortable(),
                ToggleColumn::make('is_active')->label('Aktif'),
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
            ])
            ->defaultSort('sort');
    }
}
