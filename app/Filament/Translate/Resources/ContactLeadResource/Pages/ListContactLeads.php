<?php

namespace App\Filament\Translate\Resources\ContactLeadResource\Pages;

use App\Filament\Translate\Resources\ContactLeadResource;
use Filament\Resources\Pages\ListRecords;

class ListContactLeads extends ListRecords
{
    protected static string $resource = ContactLeadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\Action::make('exportCsv')
                ->label('Export CSV')
                ->icon('heroicon-m-arrow-down-tray')
                ->color('gray')
                ->url(route('portal.translate.leads.csv'))
                ->openUrlInNewTab(false),
        ];
    }
}
