<?php

namespace App\Filament\Resources\Mesas;

use App\Filament\Resources\Mesas\Pages\CreateMesas;
use App\Filament\Resources\Mesas\Pages\EditMesas;
use App\Filament\Resources\Mesas\Pages\ListMesas;
use App\Filament\Resources\Mesas\Schemas\MesasForm;
use App\Filament\Resources\Mesas\Tables\MesasTable;
use App\Models\Mesas;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MesasResource extends Resource
{
    protected static ?string $model = Mesas::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return MesasForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MesasTable::configure($table);
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
            'index' => ListMesas::route('/'),
            'create' => CreateMesas::route('/create'),
            'edit' => EditMesas::route('/{record}/edit'),
        ];
    }
}
