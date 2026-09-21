<?php

namespace App\Filament\Resources;

use App\Models\Course;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class CourseResource extends Resource
{
    protected static ?string $model = Course::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationLabel = 'Kelas';

    protected static \UnitEnum|string|null $navigationGroup = 'Kursus';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('program_id')->label('Program')->relationship('program', 'slug')
                ->getOptionLabelFromRecordUsing(fn ($record) => $record->translated_name)
                ->searchable()->preload(),
            TextInput::make('name.id')->label('Nama Kelas (Indonesia)')->required()->maxLength(190),
            TextInput::make('name.en')->label('Nama Kelas (English)')->required()->maxLength(190),
            TextInput::make('name.zh')->label('Nama Kelas (中文)')->required()->maxLength(190),
            TextInput::make('level')->label('Level')->maxLength(50)
                ->helperText('Mis. Pemula / Menengah / Lanjutan — tampil di halaman detail'),
            TextInput::make('price')->label('Harga (Rp)')->numeric()->minValue(0)->nullable()
                ->helperText('Kosongkan = tampil "Hubungi untuk harga"'),
            TextInput::make('duration')->label('Durasi (jam)')->numeric()->minValue(1),
            TextInput::make('max_students')->label('Maks. Siswa')->numeric()->minValue(1),
            TextInput::make('sort')->numeric()->minValue(0)->default(0)->label('Urutan'),
            Toggle::make('is_active')->label('Aktif')->default(true),
        ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('translated_name')->label('Kelas')->weight('bold')->searchable(),
                TextColumn::make('program.slug')->label('Program')->badge()->color('info')->placeholder('—'),
                TextColumn::make('level')->label('Level')->badge()->color('gray'),
                TextColumn::make('price')->label('Harga')->money('IDR', divideBy: 1)
                    ->placeholder(__('messages.contact_for_price')),
                TextColumn::make('duration')->label('Jam')->suffix(' j'),
                TextColumn::make('max_students')->label('Maks'),
                TextColumn::make('sort')->label('Urutan')->sortable()->toggleable(),
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
            ->emptyStateHeading('Belum ada kelas');
    }

    public static function getRelations(): array
    {
        return [
            CourseResource\RelationManagers\SchedulesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => CourseResource\Pages\ListCourses::route('/'),
            'create' => CourseResource\Pages\CreateCourse::route('/create'),
            'edit' => CourseResource\Pages\EditCourse::route('/{record}/edit'),
        ];
    }
}
