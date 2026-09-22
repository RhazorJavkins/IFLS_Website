<?php

namespace App\Filament\Translate\Resources\DocumentResource\Pages;

use App\Filament\Translate\Resources\DocumentResource;
use App\Models\Document;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Storage;

class CreateDocument extends CreateRecord
{
    protected static string $resource = DocumentResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['uploaded_by'] = auth()->id();

        // Metadata file dari disk privat
        if (! empty($data['file_path'])) {
            $disk = Storage::disk('local');
            $data['mime_type'] = $disk->mimeType($data['file_path']) ?: null;
            $data['size_bytes'] = $disk->size($data['file_path']);
        }

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
