<?php

namespace App\Filament\Translate\Resources;

use App\Filament\Translate\Resources\TranslateJobResource\Pages;
use App\Models\TranslateJob;
use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TranslateJobResource extends Resource
{
    protected static ?string $model = TranslateJob::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-language';

    protected static \UnitEnum|string|null $navigationGroup = 'Proyek';

    protected static ?string $navigationLabel = 'Proyek Terjemahan';

    protected static ?string $modelLabel = 'Proyek';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('title')->label('Judul proyek')->required()->maxLength(200)->columnSpanFull(),
                TextInput::make('client_name')->label('Nama klien')->required()->maxLength(150),
                TextInput::make('client_phone')->label('No. WA klien')->tel()->maxLength(30),
                Select::make('source_lang')->label('Bahasa sumber')->options(TranslateJob::LANGUAGES)->required()->default('id'),
                Select::make('target_lang')->label('Bahasa target')->options(TranslateJob::LANGUAGES)->required()->default('en'),
                Select::make('service')->label('Layanan')->options(TranslateJob::SERVICES)->required()->default('document'),
                DatePicker::make('deadline')->label('Deadline'),
                Select::make('status')->label('Status')->options(TranslateJob::STATUSES)->required()->default('incoming'),
                Select::make('assigned_to')->label('Ditugaskan ke')
                    ->options(fn () => User::whereIn('role', [User::ROLE_TRANSLATOR, User::ROLE_ADMIN])->orderBy('name')->pluck('name', 'id'))
                    ->searchable(),
                TextInput::make('price')->label('Harga (Rp)')->numeric()->minValue(0)->prefix('Rp'),
                Textarea::make('notes')->label('Catatan')->rows(3)->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->searchable()->sortable()->weight('medium'),
                TextColumn::make('client_name')->label('Klien')->searchable(),
                TextColumn::make('service')->badge()->formatStateUsing(fn (string $state) => TranslateJob::SERVICES[$state] ?? $state)->color('info'),
                TextColumn::make('source_lang')->label('Dari')->formatStateUsing(fn (string $state) => strtoupper($state)),
                TextColumn::make('target_lang')->label('Ke')->formatStateUsing(fn (string $state) => strtoupper($state)),
                TextColumn::make('deadline')->label('Deadline')->date('d M Y')->color(fn ($state) => $state && $state->isPast() ? 'danger' : null)->sortable(),
                TextColumn::make('status')->badge()
                    ->formatStateUsing(fn (string $state) => TranslateJob::STATUSES[$state] ?? $state)
                    ->color(fn (string $state) => match ($state) {
                        'incoming' => 'warning',
                        'in_progress' => 'info',
                        'review' => 'primary',
                        'completed' => 'success',
                        default => 'danger',
                    }),
            ])
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('status')->options(TranslateJob::STATUSES),
            ])
            ->recordActions([
                \Filament\Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTranslateJobs::route('/'),
            'create' => Pages\CreateTranslateJob::route('/create'),
            'edit' => Pages\EditTranslateJob::route('/{record}/edit'),
        ];
    }
}
