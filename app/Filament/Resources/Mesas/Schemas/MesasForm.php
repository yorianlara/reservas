<?php

namespace App\Filament\Resources\Mesas\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class MesasForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nombre')
                    ->maxLength(255)
                    ->unique('mesas', 'nombre')
                    ->placeholder('ej. Mesa 1')
                    ->required(),
                TextInput::make('capacidad')
                    ->required()
                    ->numeric()
                    ->minValue(1)
                    ->default(2),
                Toggle::make('activa')
                    ->default(true)
                    ->required(),
            ]);
    }
}
