<?php

namespace App\Filament\Widgets;

use App\Models\Clientes;
use App\Models\Reservaciones;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class ClientesTypeOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $hoy = Carbon::now();
        $mesActual = $hoy->month;
        $mesAnterior = $hoy->copy()->subMonth()->month;

        $datos = Reservaciones::selectRaw('EXTRACT(MONTH FROM fecha_reserva) AS mes, COUNT(*) AS completadas')
        ->where('estado', 'completado')
        ->whereBetween('fecha_reserva', [
            $hoy->copy()->subMonth()->startOfMonth(),
            $hoy->copy()->endOfMonth()
        ])
        ->groupBy(DB::raw('EXTRACT(MONTH FROM fecha_reserva)'))
        ->orderBy('mes')
        ->get();

        $completadasMesAnterior = $datos->firstWhere('mes', $mesAnterior)->completadas ?? 0;
        $completadasMesActual = $datos->firstWhere('mes', $mesActual)->completadas ?? 0;

        $diferencia = $completadasMesActual - $completadasMesAnterior;

        if ($diferencia > 0) {
            $resultado = 'Aumentó';
        } elseif ($diferencia < 0 ) {
            $resultado = 'Bajó';
        } else {
            $resultado = 'Se mantuvo';
        }

        $icono = $diferencia > 0 ? 'heroicon-m-arrow-trending-up'
            : ($diferencia < 0 ? 'heroicon-m-arrow-trending-down'
            : 'heroicon-m-minus');

        $color = $diferencia > 0 ? 'success'
            : ($diferencia < 0 ? 'danger'
            : 'info');

        return [
            Stat::make('Clientes',Clientes::count())->description('Total Registrados'),

            Stat::make('Reservaciones',Reservaciones::whereToday('fecha_reserva')
            ->whereNotIn('estado', ['completado', 'cancelado'])
            ->count())
            ->description('Total para hoy'),

            Stat::make('Reservas Completadas', $diferencia)
            ->description('Referente al mes anterior: '.$resultado)
            ->descriptionIcon($icono)
            ->color($color),
        ];
    }
}
