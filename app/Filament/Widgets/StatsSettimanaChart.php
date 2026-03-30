<?php
namespace App\Filament\Widgets;
use Filament\Widgets\ChartWidget;

class StatsSettimanaChart extends ChartWidget {
    protected static ?string $heading = 'Questa Settimana';
    protected function getType(): string { return 'pie'; }
    protected function getData(): array {
        return [
            'datasets' => [['data' => [\App\Models\TableBooking::where('booking_date', '>=', now()->startOfWeek())->count(), \App\Models\Booking::where('check_in', '>=', now()->startOfWeek())->count()], 'backgroundColor' => ['#16a34a', '#2563eb']]],
            'labels' => ['Ristorante', 'Alloggi'],
        ];
    }
}
