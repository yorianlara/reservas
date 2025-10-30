<?php

namespace App\Filament\Resources\Reservaciones\Pages;

use App\Filament\Resources\Reservaciones\ReservacionesResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditReservaciones extends EditRecord
{
    protected static string $resource = ReservacionesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
