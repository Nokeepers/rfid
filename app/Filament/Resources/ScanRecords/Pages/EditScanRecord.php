<?php

namespace App\Filament\Resources\ScanRecords\Pages;

use App\Filament\Resources\ScanRecords\ScanRecordResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditScanRecord extends EditRecord
{
    protected static string $resource = ScanRecordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
