<?php

namespace App\Filament\Translate\Resources;

use App\Filament\Translate\Resources\DocumentResource\Pages;
use App\Models\Document;
use App\Models\TranslateJob;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

class DocumentResource extends Resource
{
    protected static ?string $model = Document::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-document-text';

    protected static \UnitEnum|string|null $navigationGroup = 'Dokumen';

    protected static ?string $navigationLabel = 'Dokumen';

    protected static ?string $modelLabel = 'Dokumen';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('title')->label('Judul dokumen')->required()->maxLength(200)->columnSpanFull(),
                Select::make('translate_job_id')->label('Proyek terkait')
                    ->options(fn () => TranslateJob::orderByDesc('id')->limit(100)->pluck('title', 'id'))
                    ->searchable()
                    ->nullable(),
                FileUpload::make('file_path')
                    ->label('File')
                    ->disk('local') // PRIVAT: storage/app/private/documents — bukan public!
                    ->directory('documents')
                    ->required()
                    ->maxSize(20480) // 20 MB
                    ->acceptedFileTypes([
                        'application/pdf',
                        'application/msword',
                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                        'application/vnd.ms-excel',
                        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                        'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                        'image/jpeg',
                        'image/png',
                        'text/plain',
                    ])
                    ->openable()
                    ->downloadable()
                    ->helperText('PDF/Word/Excel/PPT/JPG/PNG/TXT, maks 20 MB. Disimpan privat — hanya bisa diunduh lewat portal.'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->searchable()->weight('medium'),
                TextColumn::make('job.title')->label('Proyek')->placeholder('—'),
                TextColumn::make('mime_type')->label('Tipe')->badge()->gray()->formatStateUsing(fn (?string $state) => $state ? last(explode('/', $state)) : '—'),
                TextColumn::make('size_bytes')->label('Ukuran')->formatStateUsing(fn ($state, Document $record) => $record->humanSize()),
                TextColumn::make('created_at')->label('Diunggah')->date('d M Y')->sortable(),
            ])
            ->recordActions([
                // Unduh lewat route privat (bukan URL storage publik)
                \Filament\Actions\Action::make('download')
                    ->label('Unduh')
                    ->icon('heroicon-m-arrow-down-tray')
                    ->url(fn (Document $record) => $record->downloadUrl())
                    ->openUrlInNewTab(false),
                DeleteAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDocuments::route('/'),
            'create' => Pages\CreateDocument::route('/create'),
            'edit' => Pages\EditDocument::route('/{record}/edit'),
        ];
    }
}
