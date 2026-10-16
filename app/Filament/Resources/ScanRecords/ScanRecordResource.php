<?php

namespace App\Filament\Resources\ScanRecords;

use App\Filament\Resources\ScanRecords\Pages\CreateScanRecord;
use App\Filament\Resources\ScanRecords\Pages\EditScanRecord;
use App\Filament\Resources\ScanRecords\Pages\ListScanRecords;
use App\Filament\Resources\ScanRecords\Schemas\ScanRecordForm;
use App\Filament\Resources\ScanRecords\Tables\ScanRecordsTable;
use App\Models\ScanRecord;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ScanRecordResource extends Resource
{
    protected static ?string $model = ScanRecord::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return ScanRecordForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ScanRecordsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListScanRecords::route('/'),
            'create' => CreateScanRecord::route('/create'),
            'edit' => EditScanRecord::route('/{record}/edit'),
        ];
    }
}
