<?php

namespace App\Filament\Resources;

use App\Models\Partner;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class PartnerResource extends Resource
{
    protected static ?string $model = Partner::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-building-office-2';

    protected static ?string $navigationLabel = 'Mitra Korporat';

    protected static \UnitEnum|string|null $navigationGroup = 'Konten';

    protected static ?int $navigationSort = 5;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')->required()->maxLength(120)->label('Nama Perusahaan'),
            TextInput::make('initial')->required()->length(1)->label('Inisial (placeholder logo)'),
            TextInput::make('color')->default('#1a2a4f')->label('Warna Placeholder')
                ->helperText('Format hex, mis. #b03a3a'),
            TextInput::make('url')->url()->maxLength(255)->label('Situs Web (opsional)'),
            TextInput::make('sort')->numeric()->minValue(0)->default(0)->label('Urutan'),
            Toggle::make('is_active')->label('Aktif')->default(true),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Nama')->searchable()->sortable(),
                TextColumn::make('initial')->label('Inisial')->badge()->color('gray'),
                TextColumn::make('url')->label('Situs')->limit(30)->toggleable(),
                TextColumn::make('sort')->label('Urutan')->sortable(),
                ToggleColumn::make('is_active')->label('Aktif'),
            ])
            ->filters([
                TernaryFilter::make('is_active')->label('Status'),
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
            ->defaultSort('sort')
            ->emptyStateHeading('Belum ada mitra');
    }

    public static function getPages(): array
    {
        return [
            'index' => PartnerResource\Pages\ListPartners::route('/'),
            'create' => PartnerResource\Pages\CreatePartner::route('/create'),
            'edit' => PartnerResource\Pages\EditPartner::route('/{record}/edit'),
        ];
    }
}
