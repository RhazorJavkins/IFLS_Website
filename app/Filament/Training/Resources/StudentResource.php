<?php

namespace App\Filament\Training\Resources;

use App\Filament\Training\Resources\StudentResource\Pages;
use App\Models\Student;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-user-group';

    protected static \UnitEnum|string|null $navigationGroup = 'Kelas';

    protected static ?string $navigationLabel = 'Murid';

    protected static ?string $modelLabel = 'Murid';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('name')->label('Nama')->required()->maxLength(120)->columnSpanFull(),
                TextInput::make('phone')->label('No. WhatsApp')->tel()->maxLength(30)
                    ->helperText('Format internasional tanpa +, mis. 6281234567890 — dipakai untuk tombol WA'),
                TextInput::make('email')->email()->maxLength(150),
                Textarea::make('notes')->label('Catatan')->rows(3)->columnSpanFull(),
                Toggle::make('is_active')->label('Aktif')->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('phone')->label('WhatsApp')->placeholder('—'),
                TextColumn::make('email')->placeholder('—'),
                TextColumn::make('classes_count')->counts('classes')->label('Kelas')->alignCenter(),
                ToggleColumn::make('is_active')->label('Aktif'),
            ])
            ->recordActions([
                \Filament\Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }
}
