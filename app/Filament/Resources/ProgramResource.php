<?php

namespace App\Filament\Resources;

use App\Models\Program;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Select;
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

class ProgramResource extends Resource
{
    protected static ?string $model = Program::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $navigationLabel = 'Program';

    protected static \UnitEnum|string|null $navigationGroup = 'Kursus';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('slug')->required()->unique(ignoreRecord: true)->maxLength(50)
                ->helperText('Dipakai sebagai anchor URL: /courses#{slug}. Jangan diubah setelah publish.'),
            TextInput::make('emoji')->maxLength(8)->label('Emoji'),
            TextInput::make('name.id')->label('Nama (Indonesia)')->required()->maxLength(120),
            TextInput::make('name.en')->label('Nama (English)')->required()->maxLength(120),
            TextInput::make('name.zh')->label('Nama (中文)')->required()->maxLength(120),
            TextInput::make('badge.id')->label('Badge (Indonesia)')->required()->maxLength(60),
            TextInput::make('badge.en')->label('Badge (English)')->required()->maxLength(60),
            TextInput::make('badge.zh')->label('Badge (中文)')->required()->maxLength(60),
            Textarea::make('intro.id')->label('Deskripsi (Indonesia)')->required()->rows(3)->columnSpanFull(),
            Textarea::make('intro.en')->label('Deskripsi (English)')->required()->rows(3)->columnSpanFull(),
            Textarea::make('intro.zh')->label('Deskripsi (中文)')->required()->rows(3)->columnSpanFull(),
            Select::make('display_style')->label('Gaya Render')->options([
                'tabs' => 'Tabs (tingkatan)',
                'stepper' => 'Stepper (jenjang)',
                'cards' => 'Kartu',
            ])->required()->default('cards'),
            ColorPicker::make('color')->label('Warna CTA')->default('#1A2A4F'),
            Toggle::make('is_flagship')->label('Program Unggulan (badge merah)'),
            Toggle::make('show_coming_soon')->label('Tampilkan alert "Segera hadir offline"'),
            Textarea::make('cta_text.id')->label('Sub-teks CTA (Indonesia)')->required()->rows(2),
            Textarea::make('cta_text.en')->label('Sub-teks CTA (English)')->required()->rows(2),
            Textarea::make('cta_text.zh')->label('Sub-teks CTA (中文)')->required()->rows(2),
            TextInput::make('wa_prefill')->label('Prefill WhatsApp')->maxLength(190)
                ->helperText('Teks pesan awal saat klik tombol WhatsApp program ini'),
            TextInput::make('sort')->numeric()->minValue(0)->default(0)->label('Urutan'),
            Toggle::make('is_active')->label('Aktif')->default(true),
        ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('emoji')->label(''),
                TextColumn::make('translated_name')->label('Nama')->weight('bold')->searchable(),
                TextColumn::make('slug')->badge()->color('info'),
                TextColumn::make('translated_badge')->label('Badge')->limit(22),
                TextColumn::make('display_style')->label('Render')->badge()->color('gray'),
                TextColumn::make('features_count')->label('Fitur')->counts('features'),
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
            ->emptyStateHeading('Belum ada program');
    }

    public static function getRelations(): array
    {
        return [
            ProgramResource\RelationManagers\FeaturesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ProgramResource\Pages\ListPrograms::route('/'),
            'create' => ProgramResource\Pages\CreateProgram::route('/create'),
            'edit' => ProgramResource\Pages\EditProgram::route('/{record}/edit'),
        ];
    }
}
