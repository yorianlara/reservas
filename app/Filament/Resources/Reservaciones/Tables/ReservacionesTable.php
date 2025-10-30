<?php

namespace App\Filament\Resources\Reservaciones\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ReservacionesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('cliente.full_name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('mesa.nombre')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('fecha_reserva')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('comensales')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('estado')
                    ->badge()
                    ->colors([
                        'warning' => 'pendiente',
                        'primary' => 'confirmado',
                        'danger' => 'cancelado',
                        'success' => 'completado',
                    ])
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('estado')
                    ->options([
                        'pendiente' => 'Pendiente',
                        'confirmado' => 'Confirmado',
                        'cancelado' => 'Cancelado',
                        'completado' => 'Completado',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
