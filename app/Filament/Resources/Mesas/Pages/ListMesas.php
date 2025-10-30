<?php

namespace App\Filament\Resources\Mesas\Pages;

use App\Filament\Resources\Mesas\MesasResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMesas extends ListRecords
{
    protected static string $resource = MesasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
