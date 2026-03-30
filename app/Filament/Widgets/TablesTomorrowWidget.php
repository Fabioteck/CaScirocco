<?php
namespace App\Filament\Widgets;

use App\Models\TableBooking;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TablesTomorrowWidget extends BaseWidget
{
    protected static ?int $sort = 3;

    protected function getStats(): array
    {
        $domani = now()->addDay()->toDateString();
        $coperti = TableBooking::whereDate('booking_date', $domani)->where('status', 'confirmed')->sum('people_count');
        $tavoli = TableBooking::whereDate('booking_date', $domani)->where('status', 'confirmed')->count();

        return [
            Stat::make('Tavoli Domani', $tavoli)
                ->description("Totale {$coperti} coperti previsti")
                ->descriptionIcon('heroicon-m-users')
                ->color('success'),
        ];
    }
}
