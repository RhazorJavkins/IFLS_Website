<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TeamMemberResource\Pages;
use App\Models\TeamMember;
use App\Rules\SafeImage;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use BackedEnum;
use UnitEnum;

class TeamMemberResource extends Resource
{
    protected static ?string $model = TeamMember::class;

    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationLabel = 'Tim';

    protected static ?string $modelLabel = 'Anggota Tim';

    protected static ?string $pluralModelLabel = 'Anggota Tim';

    protected static \UnitEnum|string|null $navigationGroup = 'Konten';

    protected static ?int $navigationSort = 6;

    public static function form(\Filament\Schemas\Schema $form): \Filament\Schemas\Schema
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nama (alfabet)')
                    ->required()
                    ->maxLength(100)
                    ->helperText('Mis. YI YAN — tampil di samping nama China'),
                TextInput::make('name_cn')
                    ->label('Nama (karakter China)')
                    ->maxLength(30),
                TextInput::make('role.id')
                    ->label('Jabatan (Indonesia)')
                    ->required()
                    ->maxLength(100),
                TextInput::make('role.en')
                    ->label('Jabatan (English)')
                    ->required()
                    ->maxLength(100),
                TextInput::make('role.zh')
                    ->label('Jabatan (中文)')
                    ->required()
                    ->maxLength(100),
                FileUpload::make('photo')
                    ->label('Foto')
                    ->image()
                    ->disk('public')
                    ->directory('team')
                    ->required()
                    ->maxSize(3072)
                    ->rule(new SafeImage())
                    ->imageEditor()
                    ->columnSpanFull()
                    ->helperText('Disarankan foto persegi min. 400×400px. Foto lama otomatis tersedia setelah seeder dijalankan.'),
                Textarea::make('bio.id')
                    ->label('Bio (Indonesia) — hanya untuk direksi')
                    ->rows(3)
                    ->columnSpanFull(),
                Textarea::make('bio.en')
                    ->label('Bio (English) — hanya untuk direksi')
                    ->rows(3)
                    ->columnSpanFull(),
                Textarea::make('bio.zh')
                    ->label('Bio (中文) — hanya untuk direksi')
                    ->rows(3)
                    ->columnSpanFull(),
                TextInput::make('quote')
                    ->label('Kutipan (footer kartu direksi, opsional)')
                    ->maxLength(300)
                    ->columnSpanFull(),
                Toggle::make('is_director')
                    ->label('Direksi')
                    ->helperText('Direksi tampil besar di halaman About dengan bio'),
                Toggle::make('show_on_home')
                    ->label('Tampilkan di beranda')
                    ->default(true)
                    ->helperText('Beranda menampilkan direksi + maksimal 6 staf'),
                Toggle::make('is_active')
                    ->label('Aktif')
                    ->default(true),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\ImageColumn::make('photo')
                    ->label('Foto')
                    ->circular(false)
                    ->square()
                    ->width(56)
                    ->height(56),
                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->formatStateUsing(fn ($record) => trim(($record->name_cn ? $record->name_cn.' ' : '').$record->name)),
                TextColumn::make('translated_role')
                    ->label('Jabatan')
                    ->limit(30),
                TextColumn::make('sort')
                    ->label('Urutan')
                    ->sortable(),
                IconColumn::make('is_director')->label('Direksi')->boolean(),
                ToggleColumn::make('is_active')->label('Aktif'),
            ])
            ->filters([
                \Filament\Tables\Filters\TernaryFilter::make('is_director')->label('Direksi'),
                \Filament\Tables\Filters\TernaryFilter::make('is_active')->label('Status'),
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
            ->emptyStateHeading('Belum ada anggota tim');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTeamMembers::route('/'),
            'create' => Pages\CreateTeamMember::route('/create'),
            'edit' => Pages\EditTeamMember::route('/{record}/edit'),
        ];
    }
}
