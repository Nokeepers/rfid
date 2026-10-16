<?php

namespace App\Filament\Resources\RfidCards;

use App\Filament\Resources\RfidCards\Pages\CreateRfidCard;
use App\Filament\Resources\RfidCards\Pages\EditRfidCard;
use App\Filament\Resources\RfidCards\Pages\ListRfidCards;
use App\Filament\Resources\RfidCards\Schemas\RfidCardForm;
use App\Filament\Resources\RfidCards\Tables\RfidCardsTable;
use App\Models\RfidCard;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class RfidCardResource extends Resource
{
    protected static ?string $model = RfidCard::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return RfidCardForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RfidCardsTable::configure($table);
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
            'index' => ListRfidCards::route('/'),
            'create' => CreateRfidCard::route('/create'),
            'edit' => EditRfidCard::route('/{record}/edit'),
        ];
    }
}
