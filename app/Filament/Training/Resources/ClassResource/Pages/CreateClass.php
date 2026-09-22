<?php

namespace App\Filament\Training\Resources\ClassResource\Pages;

use App\Filament\Training\Resources\ClassResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreateClass extends CreateRecord
{
    protected static string $resource = ClassResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
