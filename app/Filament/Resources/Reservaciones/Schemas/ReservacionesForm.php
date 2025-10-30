<?php

namespace App\Filament\Resources\Reservaciones\Schemas;

use Coolsam\Flatpickr\Forms\Components\Flatpickr;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ReservacionesForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('cliente_id')
                    ->required()
                    ->relationship('cliente', 'nombre')
                    ->searchable()
                    ->preload(),
                Select::make('mesas_id')
                    ->required()
                    ->relationship('mesa', 'nombre')
                    ->searchable()
                    ->preload(),
                Flatpickr::make('fecha_reserva')
                    ->format('m/d/Y H:i')
                    ->time(true) 
                    ->minDate('today') 
                    ->time24hr(true)
                    ->hourIncrement(1)
                    ->minuteIncrement(5) 
                    ->seconds(false)
                    ->locale('es')
                    ->required(),   
                TextInput::make('comensales')
                    ->required()
                    ->numeric()
                    ->default(2),
                Select::make('estado')
                    ->options([
                        'pendiente' => 'Pendiente',
                        'confirmado' => 'Confirmado',
                        'cancelado' => 'Cancelada',
                        'completado' => 'Completado',
                    ])
                    ->required()
                    ->default('pendiente'),
                Textarea::make('notas')
                    ->columnSpanFull(),
            ]);
    }
}
