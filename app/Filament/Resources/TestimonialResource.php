<?php

namespace App\Filament\Resources;

use App\Models\Testimonial;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class TestimonialResource extends Resource
{
    protected static ?string $model = Testimonial::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-chat-bubble-left-ellipsis';

    protected static ?string $navigationLabel = 'Testimoni';

    protected static \UnitEnum|string|null $navigationGroup = 'Konten';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name.id')->label('Nama (Indonesia)')->required()->maxLength(120),
            TextInput::make('name.en')->label('Nama (English)')->required()->maxLength(120),
            TextInput::make('name.zh')->label('Nama (中文)')->required()->maxLength(120),
            Textarea::make('content.id')->label('Testimoni (Indonesia)')->required()->rows(3)->columnSpanFull(),
            Textarea::make('content.en')->label('Testimoni (English)')->required()->rows(3)->columnSpanFull(),
            Textarea::make('content.zh')->label('Testimoni (中文)')->required()->rows(3)->columnSpanFull(),
            TextInput::make('sort')->numeric()->minValue(0)->default(0)->label('Urutan'),
            Toggle::make('is_active')->label('Aktif')->default(true),
        ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('translated_name')->label('Nama')->searchable()->sortable(),
                TextColumn::make('translated_content')->label('Isi')->limit(60),
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
            ->emptyStateHeading('Belum ada testimoni');
    }

    public static function getPages(): array
    {
        return [
            'index' => TestimonialResource\Pages\ListTestimonials::route('/'),
            'create' => TestimonialResource\Pages\CreateTestimonial::route('/create'),
            'edit' => TestimonialResource\Pages\EditTestimonial::route('/{record}/edit'),
        ];
    }
}
