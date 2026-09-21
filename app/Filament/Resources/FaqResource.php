<?php

namespace App\Filament\Resources;

use App\Models\Faq;
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

class FaqResource extends Resource
{
    protected static ?string $model = Faq::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-question-mark-circle';

    protected static ?string $navigationLabel = 'FAQ';

    protected static \UnitEnum|string|null $navigationGroup = 'Konten';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('question.id')->label('Pertanyaan (Indonesia)')->required()->maxLength(255)->columnSpanFull(),
            TextInput::make('question.en')->label('Pertanyaan (English)')->required()->maxLength(255)->columnSpanFull(),
            TextInput::make('question.zh')->label('Pertanyaan (中文)')->required()->maxLength(255)->columnSpanFull(),
            Textarea::make('answer.id')->label('Jawaban (Indonesia)')->required()->rows(4)->columnSpanFull(),
            Textarea::make('answer.en')->label('Jawaban (English)')->required()->rows(4)->columnSpanFull(),
            Textarea::make('answer.zh')->label('Jawaban (中文)')->required()->rows(4)->columnSpanFull(),
            TextInput::make('sort')->numeric()->minValue(0)->default(0)->label('Urutan'),
            Toggle::make('is_active')->label('Aktif')->default(true),
        ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('translated_question')->label('Pertanyaan')->limit(60)->searchable(),
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
            ->emptyStateHeading('Belum ada FAQ');
    }

    public static function getPages(): array
    {
        return [
            'index' => FaqResource\Pages\ListFaqs::route('/'),
            'create' => FaqResource\Pages\CreateFaq::route('/create'),
            'edit' => FaqResource\Pages\EditFaq::route('/{record}/edit'),
        ];
    }
}
