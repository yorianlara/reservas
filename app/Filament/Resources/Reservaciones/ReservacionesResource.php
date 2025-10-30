<?php

namespace App\Filament\Resources\Reservaciones;

use App\Filament\Resources\Reservaciones\Pages\CreateReservaciones;
use App\Filament\Resources\Reservaciones\Pages\EditReservaciones;
use App\Filament\Resources\Reservaciones\Pages\ListReservaciones;
use App\Filament\Resources\Reservaciones\Schemas\ReservacionesForm;
use App\Filament\Resources\Reservaciones\Tables\ReservacionesTable;
use App\Models\Reservaciones;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ReservacionesResource extends Resource
{
    protected static ?string $model = Reservaciones::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;

    protected static ?string $recordTitleAttribute = 'fecha_reserva';

    public static function form(Schema $schema): Schema
    {
        return ReservacionesForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ReservacionesTable::configure($table);
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
            'index' => ListReservaciones::route('/'),
            'create' => CreateReservaciones::route('/create'),
            'edit' => EditReservaciones::route('/{record}/edit'),
        ];
    }
}
