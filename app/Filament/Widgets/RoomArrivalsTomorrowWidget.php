<?php
namespace App\Filament\Widgets;

use App\Models\Booking;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class RoomArrivalsTomorrowWidget extends BaseWidget
{
    protected static ?int $sort = 4;

    protected function getStats(): array
    {
        $arrivi = Booking::whereDate('check_in', now()->addDay())->count();

        return [
            Stat::make('Arrivi Stanze Domani', $arrivi)
                ->description('Check-in in programma')
                ->descriptionIcon('heroicon-m-key')
                ->color('info'),
        ];
    }
}