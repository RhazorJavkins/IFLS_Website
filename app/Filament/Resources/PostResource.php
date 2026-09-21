<?php

namespace App\Filament\Resources;

use App\Models\Post;
use App\Rules\SafeImage;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Artikel Blog';

    protected static \UnitEnum|string|null $navigationGroup = 'Konten';

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('title.id')->label('Judul (Indonesia)')->required()->maxLength(190)->live(onBlur: true)
                ->afterStateUpdated(function (string $operation, $state, \Filament\Schemas\Components\Utilities\Set $set) {
                    if ($operation === 'create') {
                        $set('slug', \Illuminate\Support\Str::slug($state));
                    }
                }),
            TextInput::make('title.en')->label('Judul (English)')->required()->maxLength(190),
            TextInput::make('title.zh')->label('Judul (中文)')->required()->maxLength(190),
            TextInput::make('slug')->required()->unique(ignoreRecord: true)->maxLength(190)
                ->helperText('URL artikel: /{bahasa}/blog/{slug}'),
            Textarea::make('excerpt.id')->label('Ringkasan (Indonesia)')->required()->rows(3)->columnSpanFull(),
            Textarea::make('excerpt.en')->label('Ringkasan (English)')->required()->rows(3)->columnSpanFull(),
            Textarea::make('excerpt.zh')->label('Ringkasan (中文)')->required()->rows(3)->columnSpanFull(),
            Textarea::make('body.id')->label('Isi Artikel (Indonesia) — pisahkan paragraf dengan baris kosong')->required()->rows(8)->columnSpanFull(),
            Textarea::make('body.en')->label('Isi Artikel (English)')->required()->rows(8)->columnSpanFull(),
            Textarea::make('body.zh')->label('Isi Artikel (中文)')->required()->rows(8)->columnSpanFull(),
            FileUpload::make('cover_image')
                ->label('Gambar Cover (opsional)')
                ->image()
                ->disk('public')
                ->directory('posts')
                ->maxSize(3072)
                ->rule(new SafeImage())
                ->columnSpanFull(),
            Toggle::make('is_published')->label('Publikasikan')->default(true),
            DatePicker::make('published_at')->label('Tanggal Publikasi')->default(now())->native(false),
        ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('translated_title')->label('Judul')->limit(50)->searchable(),
                TextColumn::make('slug')->limit(30)->toggleable(),
                IconColumn::make('is_published')->label('Publik')->boolean(),
                TextColumn::make('published_at')->label('Tanggal')->date('d M Y')->sortable(),
            ])
            ->filters([
                TernaryFilter::make('is_published')->label('Status'),
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
            ->defaultSort('published_at', 'desc')
            ->emptyStateHeading('Belum ada artikel');
    }

    public static function getPages(): array
    {
        return [
            'index' => PostResource\Pages\ListPosts::route('/'),
            'create' => PostResource\Pages\CreatePost::route('/create'),
            'edit' => PostResource\Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
