<?php

namespace App\Filament\Translate\Resources;

use App\Filament\Translate\Resources\ContactLeadResource\Pages;
use App\Models\ContactLead;
use Filament\Actions\Action;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

/**
 * Leads dari form website — di portal translate bersifat READ-ONLY:
 * lihat, filter, tandai sudah dihubungi, export CSV.
 * Kontrol penuh (edit/hapus) tetap di /admin.
 */
class ContactLeadResource extends Resource
{
    protected static ?string $model = ContactLead::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-m-inbox-arrow-down';

    protected static \UnitEnum|string|null $navigationGroup = 'Leads';

    protected static ?string $navigationLabel = 'Leads Website';

    protected static ?string $modelLabel = 'Lead';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit($record): bool
    {
        return false;
    }

    public static function canDelete($record): bool
    {
        return false;
    }

    public static function canDeleteAny(): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        // Tidak dipakai (read-only) — wajib tetap didefinisikan
        return $schema->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Nama')->searchable()->weight('medium'),
                TextColumn::make('email')->searchable(),
                TextColumn::make('phone')->label('Telepon')->placeholder('—'),
                TextColumn::make('program')->label('Program')->badge()->color('info')->placeholder('—'),
                TextColumn::make('message')->label('Pesan')->limit(50)->wrap(),
                TextColumn::make('contacted_at')->label('Dihubungi')
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state ? '✓ ' . $state->format('d M') : 'Belum')
                    ->color(fn ($state) => $state ? 'success' : 'warning')
                    ->sortable(),
                TextColumn::make('created_at')->label('Masuk')->diffForHumans()->sortable(),
            ])
            ->filters([
                \Filament\Tables\Filters\TernaryFilter::make('contacted')
                    ->label('Sudah dihubungi')
                    ->attribute('contacted_at')
                    ->nullable(),
            ])
            ->recordActions([
                Action::make('markContacted')
                    ->label('Tandai Dihubungi')
                    ->icon('heroicon-m-check')
                    ->color('success')
                    ->visible(fn (ContactLead $record) => $record->contacted_at === null)
                    ->action(fn (ContactLead $record) => $record->update(['contacted_at' => now()])),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContactLeads::route('/'),
        ];
    }
}
