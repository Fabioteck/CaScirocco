<?php
namespace App\Filament\Widgets;
use Filament\Widgets\ChartWidget;

class StatsGiornoChart extends ChartWidget {
    protected static ?string $heading = 'Oggi';
    protected function getType(): string { return 'pie'; }
    protected function getData(): array {
        return [
            'datasets' => [['data' => [\App\Models\TableBooking::whereDate('booking_date', today())->count(), \App\Models\Booking::whereDate('check_in', today())->count()], 'backgroundColor' => ['#22c55e', '#3b82f6']]],
            'labels' => ['Ristorante', 'Alloggi'],
        ];
    }
}
