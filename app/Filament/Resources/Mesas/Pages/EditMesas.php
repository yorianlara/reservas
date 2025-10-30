<?php

namespace App\Filament\Resources\Mesas\Pages;

use App\Filament\Resources\Mesas\MesasResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMesas extends EditRecord
{
    protected static string $resource = MesasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
