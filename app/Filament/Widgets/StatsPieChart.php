<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\TableBooking;
use App\Models\Booking;

class StatsPieChart extends ChartWidget
{
    protected static ?string $heading = 'Riepilogo Prenotazioni';

    protected function getType(): string
    {
        return 'pie';
    }

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Prenotazioni Totali',
                    'data' => [
                        TableBooking::count(), // Conteggio Tavoli
                        Booking::count(),      // Conteggio Stanze
                    ],
                    'backgroundColor' => ['#22c55e', '#3b82f6'],
                ],
            ],
            'labels' => ['Ristorante', 'Alloggi'],
        ];
    }
}
