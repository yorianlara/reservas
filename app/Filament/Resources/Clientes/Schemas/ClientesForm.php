<?php

namespace App\Filament\Resources\Clientes\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ClientesForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nombre')
                    ->maxLength(255)
                    ->autocomplete(false)
                    ->required(),
                TextInput::make('apellido')
                    ->maxLength(255)
                    ->autocomplete(false)
                    ->required(),
                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->maxLength(255)
                    ->unique('clientes', 'email')
                    ->autocomplete(false)
                    ->required(),
                TextInput::make('telefono')
                    ->tel()
                    ->prefix('+34')
                    ->maxLength(20)
                    ->unique('clientes', 'telefono')
                    ->autocomplete(false)
                    ->required(),
            ]);
    }
}
