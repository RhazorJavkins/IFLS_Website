<?php

namespace App\Filament\Resources;

use App\Models\PricingPlan;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class PricingPlanResource extends Resource
{
    protected static ?string $model = PricingPlan::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-tag';

    protected static ?string $navigationLabel = 'Paket Harga';

    protected static \UnitEnum|string|null $navigationGroup = 'Kursus';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('icon')->label('Ikon FontAwesome')->maxLength(50)->placeholder('fa-solid fa-users'),
            TextInput::make('name.id')->label('Nama Paket (Indonesia)')->required()->maxLength(120),
            TextInput::make('name.en')->label('Nama Paket (English)')->required()->maxLength(120),
            TextInput::make('name.zh')->label('Nama Paket (中文)')->required()->maxLength(120),
            Textarea::make('price_note.id')->label('Catatan Harga (Indonesia)')->required()->rows(2),
            Textarea::make('price_note.en')->label('Catatan Harga (English)')->required()->rows(2),
            Textarea::make('price_note.zh')->label('Catatan Harga (中文)')->required()->rows(2),
            TextInput::make('sort')->numeric()->minValue(0)->default(0)->label('Urutan'),
            Toggle::make('is_active')->label('Aktif')->default(true),
        ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('icon')->label('Ikon'),
                TextColumn::make('translated_name')->label('Paket')->weight('bold')->searchable(),
                TextColumn::make('translated_price_note')->label('Catatan Harga')->limit(30),
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
            ->emptyStateHeading('Belum ada paket harga');
    }

    public static function getPages(): array
    {
        return [
            'index' => PricingPlanResource\Pages\ListPricingPlans::route('/'),
            'create' => PricingPlanResource\Pages\CreatePricingPlan::route('/create'),
            'edit' => PricingPlanResource\Pages\EditPricingPlan::route('/{record}/edit'),
        ];
    }
}
