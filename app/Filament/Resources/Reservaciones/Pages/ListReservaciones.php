<?php

namespace App\Filament\Resources\Reservaciones\Pages;

use App\Filament\Resources\Reservaciones\ReservacionesResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListReservaciones extends ListRecords
{
    protected static string $resource = ReservacionesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
