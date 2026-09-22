<?php

namespace App\Filament\Translate\Resources\TranslateJobResource\Pages;

use App\Filament\Translate\Resources\TranslateJobResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTranslateJob extends CreateRecord
{
    protected static string $resource = TranslateJobResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
