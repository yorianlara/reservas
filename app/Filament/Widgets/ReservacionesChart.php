<?php

namespace App\Filament\Widgets;

use App\Models\Reservaciones;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class ReservacionesChart extends ChartWidget
{
    protected ?string $heading = 'Gráfica de Reservaciones';
    protected ?string $pollingInterval = '10s';
    protected ?string $maxHeight = '400px';

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
        // Configurar fechas según filtro
        [$startDate, $endDate, $interval] = $this->getDateRange();

        // Generar tendencia usando la fecha de reserva (fecha_reserva)
        $data = Trend::model(Reservaciones::class)
            ->dateColumn('fecha_reserva') // Usar la columna de fecha de reserva
            ->between(start: $startDate, end: $endDate)
            ->{$interval}()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Número de Reservaciones',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                    'backgroundColor' => $this->getBackgroundColors($data),
                    'borderColor' => '#4F46E5',
                    'borderWidth' => 2,
                    'fill' => true,
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $this->formatDateLabel($value->date, $interval)),
        ];
    }

    protected function getDateRange(): array
    {
        return match ($this->filter) {
            'today' => [
                now()->startOfDay(),
                now()->endOfDay(),
                'perHour'
            ],
            'week' => [
                now()->startOfWeek(),
                now()->endOfWeek(),
                'perDay'
            ],
            'month' => [
                now()->startOfMonth(),
                now()->endOfMonth(),
                'perDay'
            ],
            'last_6_months' => [
                now()->subMonths(6),
                now(),
                'perMonth'
            ],
            default => [ // year
                now()->startOfYear(),
                now()->endOfYear(),
                'perMonth'
            ],
        };
    }

    protected function formatDateLabel(string $date, string $interval): string
    {
        $date = now()->parse($date);

        return match ($interval) {
            'perHour' => $date->format('H:i'),
            'perDay' => $date->format('d M'),
            'perMonth' => $date->format('M Y'),
            'perYear' => $date->format('Y'),
            default => $date->format('d M Y'),
        };
    }

    protected function getBackgroundColors($data): array
    {
        return $data->map(function (TrendValue $value) {
            return match ($value->aggregate) {
                0 => '#E5E7EB', // Gris para cero
                1, 2 => '#60A5FA', // Azul claro para pocas reservas
                3, 4 => '#3B82F6', // Azul medio
                default => '#1D4ED8', // Azul oscuro para muchas reservas
            };
        })->toArray();
    }

    protected function getType(): string
    {
        return 'bar';
    }

    public function getDescription(): ?string
    {
        return 'Evolución de las reservaciones según la fecha de reserva';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'top',
                ],
                'tooltip' => [
                    'backgroundColor' => '#1F2937',
                    'titleColor' => '#F9FAFB',
                    'bodyColor' => '#F9FAFB',
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'stepSize' => 1,
                        'precision' => 0,
                    ],
                    'grid' => [
                        'color' => '#E5E7EB',
                    ],
                ],
                'x' => [
                    'grid' => [
                        'color' => '#E5E7EB',
                    ],
                ],
            ],
            'maintainAspectRatio' => false,
        ];
    }
}