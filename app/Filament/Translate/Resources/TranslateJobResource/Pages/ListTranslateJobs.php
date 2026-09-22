<?php

namespace App\Filament\Translate\Resources\TranslateJobResource\Pages;

use App\Filament\Translate\Resources\TranslateJobResource;
use Filament\Resources\Pages\ListRecords;

class ListTranslateJobs extends ListRecords
{
    protected static string $resource = TranslateJobResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\CreateAction::make(),
        ];
    }
}
