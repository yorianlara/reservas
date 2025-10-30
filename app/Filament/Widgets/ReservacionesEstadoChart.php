<?php

namespace App\Filament\Widgets;

use App\Models\Reservaciones;
use Filament\Widgets\ChartWidget;

class ReservacionesEstadoChart extends ChartWidget
{
    protected ?string $heading = 'Reservaciones por Estado';
    protected ?string $maxHeight = '300px';
    protected bool $isCollapsible = true;

    public ?string $filter = 'year';

    protected function getFilters(): ?array
    {
        return [
            'today' => 'Hoy',
            'week' => 'Esta semana',
            'month' => 'Este mes',
            'year' => 'Este año',
            'last_6_months' => 'Últimos 6 meses',
        ];
    }

    protected function getData(): array
    {
        // Obtener el rango de fechas según el filtro
        [$startDate, $endDate] = $this->getDateRange();

        $estados = Reservaciones::selectRaw('estado, COUNT(*) as count')
            ->whereBetween('fecha_reserva', [$startDate, $endDate])
            ->groupBy('estado')
            ->get();

        $colores = [
            'completado' => '#10B981', // Verde
            'pendiente' => '#F59E0B',  // Amarillo
            'cancelado' => '#EF4444',  // Rojo
            'confirmado' => '#3B82F6', // Azul
        ];

        return [
            'datasets' => [
                [
                    'label' => 'Reservaciones por Estado',
                    'data' => $estados->pluck('count')->toArray(),
                    'backgroundColor' => $estados->map(fn ($item) => $colores[$item->estado] ?? '#6B7280')->toArray(),
                    'borderWidth' => 0,
                ],
            ],
            'labels' => $estados->pluck('estado')->map(fn ($estado) => ucfirst($estado))->toArray(),
        ];
    }

    protected function getDateRange(): array
    {
        return match ($this->filter) {
            'today' => [
                now()->startOfDay(),
                now()->endOfDay(),
            ],
            'week' => [
                now()->startOfWeek(),
                now()->endOfWeek(),
            ],
            'month' => [
                now()->startOfMonth(),
                now()->endOfMonth(),
            ],
            'last_6_months' => [
                now()->subMonths(6),
                now(),
            ],
            default => [ // year
                now()->startOfYear(),
                now()->endOfYear(),
            ],
        };
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'position' => 'bottom',
                ],
            ],
        ];
    }

    public function getDescription(): ?string
    {
        return 'Distribución de reservaciones por estado según el período seleccionado';
    }
}