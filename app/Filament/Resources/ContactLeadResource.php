<?php

namespace App\Filament\Resources;

use App\Models\ContactLead;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Support\Str;

class ContactLeadResource extends Resource
{
    protected static ?string $model = ContactLead::class;

    // Union type harus sama persis dengan deklarasi parent (Filament 4)
    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-inbox-arrow-down';

    protected static ?string $navigationLabel = 'Leads Kontak';

    protected static ?string $modelLabel = 'Lead';

    protected static ?string $pluralModelLabel = 'Leads';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')->label('Nama')->required()->maxLength(120),
            TextInput::make('email')->label('Email')->email()->required()->maxLength(190),
            TextInput::make('phone')->label('Telepon')->maxLength(30),
            TextInput::make('program')->label('Program Diminati')->maxLength(80),
            TextInput::make('subject')->label('Subjek')->maxLength(190),
            Textarea::make('message')->label('Pesan')->required()->rows(5)->maxLength(3000)->columnSpanFull(),
            DateTimePicker::make('contacted_at')->label('Dihubungi Pada')->native(false),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('program')
                    ->label('Program')
                    ->badge()
                    ->color('info')
                    ->limit(22)
                    ->placeholder('—'),
                TextColumn::make('phone')
                    ->label('Telepon')
                    ->copyable()
                    ->copyMessage('Nomor disalin')
                    ->placeholder('—'),
                TextColumn::make('email')
                    ->label('Email')
                    ->copyable()
                    ->copyMessage('Email disalin')
                    ->toggleable(),
                IconColumn::make('is_contacted')
                    ->label('Dihubungi')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-clock')
                    ->trueColor('success')
                    ->falseColor('warning'),
                TextColumn::make('locale')
                    ->label('Bahasa')
                    ->badge()
                    ->color('gray')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->label('Diterima')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'new' => 'Belum dihubungi',
                        'done' => 'Sudah dihubungi',
                    ])
                    ->query(function ($query, array $data) {
                        return match ($data['value'] ?? null) {
                            'new' => $query->whereNull('contacted_at'),
                            'done' => $query->whereNotNull('contacted_at'),
                            default => $query,
                        };
                    }),
                SelectFilter::make('locale')
                    ->label('Bahasa')
                    ->options(['id' => 'Indonesia', 'en' => 'English', 'zh' => '中文']),
            ])
            ->actions([
                \Filament\Actions\ViewAction::make(),
                \Filament\Actions\Action::make('whatsapp')
                    ->label('WhatsApp')
                    ->icon('heroicon-m-chat-bubble-left-right')
                    ->color('success')
                    ->openUrlInNewTab()
                    ->url(function (ContactLead $record) {
                        $text = 'Halo ' . $record->name . ', saya dari IF Language School. Terima kasih sudah menghubungi kami — ada yang bisa kami bantu?';

                        return 'https://wa.me/' . preg_replace('/\D/', '', $record->phone ?: '') . '?text=' . rawurlencode($text);
                    })
                    ->visible(fn (ContactLead $record) => filled($record->phone)),
            ])
            ->bulkActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\BulkAction::make('markContacted')
                        ->label('Tandai Sudah Dihubungi')
                        ->icon('heroicon-m-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(fn ($records) => $records->each->update(['contacted_at' => now()])),
                    \Filament\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->emptyStateHeading('Belum ada lead')
            ->emptyStateDescription('Lead dari form kontak di website akan muncul di sini.');
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema->components([
            TextEntry::make('name')->label('Nama')->weight('bold'),
            TextEntry::make('email')->label('Email')->copyable(),
            TextEntry::make('phone')->label('Telepon')->copyable()->placeholder('—'),
            TextEntry::make('program')->label('Program Diminati')->badge()->color('info')->placeholder('—'),
            TextEntry::make('subject')->label('Subjek')->placeholder('—'),
            TextEntry::make('locale')->label('Bahasa Form')->badge()->color('gray'),
            TextEntry::make('message')->label('Pesan')->columnSpanFull(),
            TextEntry::make('contacted_at')->label('Dihubungi Pada')->dateTime('d M Y, H:i')->placeholder('Belum dihubungi'),
            TextEntry::make('created_at')->label('Diterima')->dateTime('d M Y, H:i'),
        ])->columns(3);
    }

    public static function getPages(): array
    {
        return [
            'index' => ContactLeadResource\Pages\ListContactLeads::route('/'),
            'view' => ContactLeadResource\Pages\ViewContactLead::route('/{record}'),
        ];
    }
}
