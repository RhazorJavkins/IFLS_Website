<?php

namespace App\Filament\Translate\Resources\TranslateJobResource\Pages;

use App\Filament\Translate\Resources\TranslateJobResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTranslateJob extends EditRecord
{
    protected static string $resource = TranslateJobResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
