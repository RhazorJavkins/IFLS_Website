<?php

namespace App\Filament\Training\Resources;

use App\Filament\Training\Resources\ClassResource\Pages;
use App\Models\Course;
use App\Models\SchoolClass;
use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ClassResource extends Resource
{
    protected static ?string $model = SchoolClass::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-academic-cap';

    protected static \UnitEnum|string|null $navigationGroup = 'Kelas';

    protected static ?string $navigationLabel = 'Kelas Saya';

    protected static ?string $modelLabel = 'Kelas';

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        // Guru hanya melihat kelas yang diajarnya; admin melihat semua.
        $query = parent::getEloquentQuery();

        if (auth()->user()?->isTeacher()) {
            $query->where('teacher_id', auth()->id());
        }

        return $query;
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->isAdmin() ?? false; // kelas dibuat admin; guru mengisi laporan
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('name')
                    ->label('Nama kelas')
                    ->required()
                    ->maxLength(120)
                    ->columnSpanFull(),
                Select::make('course_id')
                    ->label('Program kursus')
                    ->options(fn () => Course::orderBy('id')->pluck('name', 'id'))
                    ->searchable()
                    ->nullable(),
                TextInput::make('location')
                    ->label('Lokasi kelas')
                    ->maxLength(120)
                    ->placeholder('mis. Ruang 101 / Online')
                    ->helperText('Nama ruangan untuk kelas offline, atau "Online"'),
                Select::make('teacher_id')
                    ->label('Guru pengajar')
                    ->options(fn () => User::where('role', User::ROLE_TEACHER)->orWhere('role', User::ROLE_ADMIN)->orderBy('name')->pluck('name', 'id'))
                    ->searchable()
                    ->required(),
                DatePicker::make('started_at')->label('Tanggal mulai')->nullable(),
                DatePicker::make('ended_at')->label('Tanggal selesai')->nullable()
                    ->afterOrEqual('started_at'),
                Select::make('students')
                    ->label('Murid')
                    ->relationship('students', 'name')
                    ->multiple()
                    ->searchable()
                    ->preload(),
                Select::make('status')
                    ->options(['active' => 'Aktif', 'finished' => 'Selesai', 'cancelled' => 'Dibatalkan'])
                    ->required()
                    ->default('active'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Kelas')->searchable()->sortable(),
                TextColumn::make('course.name')->label('Program')->placeholder('—'),
                TextColumn::make('location')->label('Lokasi')
                    ->badge()
                    ->color(fn (?string $state) => $state === 'Online' ? 'info' : 'gray')
                    ->placeholder('—'),
                TextColumn::make('period')->label('Periode')->placeholder('—'),
                TextColumn::make('teacher.name')->label('Guru')->sortable(),
                TextColumn::make('students_count')->counts('students')->label('Murid')->alignCenter(),
                TextColumn::make('sessions_count')->counts('sessions')->label('Pertemuan')->alignCenter(),
                TextColumn::make('status')->badge()
                    ->formatStateUsing(fn (string $state) => match ($state) {
                        'active' => 'Aktif', 'finished' => 'Selesai', default => 'Dibatalkan',
                    })
                    ->color(fn (string $state) => match ($state) {
                        'active' => 'success', 'finished' => 'info', default => 'danger',
                    }),
            ])
            ->recordActions([
                \Filament\Actions\ViewAction::make(),
                \Filament\Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClasses::route('/'),
            'create' => Pages\CreateClass::route('/create'),
            'view' => Pages\ViewClass::route('/{record}'),
            'edit' => Pages\EditClass::route('/{record}/edit'),
            'attendance' => Pages\ManageAttendance::route('/{record}/attendance'),
            'grades' => Pages\ManageGrades::route('/{record}/grades'),
            'report' => Pages\ClassReport::route('/{record}/report'),
        ];
    }
}
