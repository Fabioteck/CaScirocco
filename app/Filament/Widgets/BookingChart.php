<?php

namespace App\Filament\Widgets;

use App\Models\TableBooking;
use App\Models\Booking;
use Filament\Widgets\ChartWidget;
use Carbon\Carbon;

class BookingChart extends ChartWidget
{
    protected static ?string $heading = 'Occupazione Settimanale';
    protected static ?int $sort = 3; // Lo mettiamo come secondo widget
    protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {
        $tableData = [];
        $roomData = [];
        $labels = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $labels[] = $date->format('d/m');
            
            // Conteggi (Usa try-catch o verifica se i modelli esistono per sicurezza)
            $tableData[] = TableBooking::whereDate('booking_date', $date->toDateString())->count();
            // All'interno del ciclo for nel file BookingChart.php
            $roomData[] = Booking::whereDate('check_in', $date->toDateString())->count();

            //$roomData[] = Booking::whereDate('booking_date', $date->toDateString())->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Tavoli',
                    'data' => $tableData,
                    'borderColor' => '#b45309',
                    'backgroundColor' => 'rgba(180, 83, 9, 0.1)',
                ],
                [
                    'label' => 'Stanze',
                    'data' => $roomData,
                    'borderColor' => '#57534e',
                    'backgroundColor' => 'rgba(87, 83, 78, 0.1)',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
