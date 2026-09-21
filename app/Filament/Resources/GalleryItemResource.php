<?php

namespace App\Filament\Resources;

use App\Models\GalleryItem;
use App\Rules\SafeImage;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class GalleryItemResource extends Resource
{
    protected static ?string $model = GalleryItem::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationLabel = 'Galeri';

    protected static \UnitEnum|string|null $navigationGroup = 'Konten';

    protected static ?int $navigationSort = 6;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            FileUpload::make('image')
                ->label('Foto')
                ->image()
                ->disk('public')
                ->directory('gallery')
                ->maxSize(3072)
                ->rule(new SafeImage())
                ->required()
                ->columnSpanFull(),
            Textarea::make('caption.id')->label('Keterangan (Indonesia)')->rows(2),
            Textarea::make('caption.en')->label('Keterangan (English)')->rows(2),
            Textarea::make('caption.zh')->label('Keterangan (中文)')->rows(2),
            TextInput::make('sort')->numeric()->minValue(0)->default(0)->label('Urutan'),
            Toggle::make('is_active')->label('Aktif')->default(true),
        ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')->label('Foto')->disk('public'),
                TextColumn::make('translated_caption')->label('Keterangan')->limit(40),
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
            ->emptyStateHeading('Belum ada foto galeri');
    }

    public static function getPages(): array
    {
        return [
            'index' => GalleryItemResource\Pages\ListGalleryItems::route('/'),
            'create' => GalleryItemResource\Pages\CreateGalleryItem::route('/create'),
            'edit' => GalleryItemResource\Pages\EditGalleryItem::route('/{record}/edit'),
        ];
    }
}
