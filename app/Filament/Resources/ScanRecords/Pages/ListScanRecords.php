<?php

namespace App\Filament\Resources\ScanRecords\Pages;

use App\Filament\Resources\ScanRecords\ScanRecordResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListScanRecords extends ListRecords
{
    protected static string $resource = ScanRecordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
