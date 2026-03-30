<?php

namespace App\Filament\Widgets;

use App\Models\TableBooking;
use App\Models\Booking;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $today = Carbon::today();
        
        // Conteggi per le pendenze (Stati 'pending')
        $pendingTables = TableBooking::where('status', 'pending')->count();
        $pendingRooms = Booking::where('status', 'pending')->count();

        return [
            // --- RIGA 1: RISTORAZIONE (Polesine Style) ---
            Stat::make('Coperti Pranzo', TableBooking::whereDate('booking_date', $today)->where('slot', 'pranzo')->where('status', 'confirmed')->sum('people_count') ?? 0)
                ->description('Totale attesi oggi')
                ->descriptionIcon('heroicon-m-sun') 
                ->color('warning'),

            Stat::make('Coperti Cena', TableBooking::whereDate('booking_date', $today)->where('slot', 'cena')->where('status', 'confirmed')->sum('people_count') ?? 0)
                ->description('Totale attesi oggi')
                ->descriptionIcon('heroicon-m-moon') 
                ->color('indigo'),

            Stat::make('Tavoli Pendenti', $pendingTables)
                ->description($pendingTables > 0 ? 'Da approvare subito' : 'Tutto gestito')
                ->descriptionIcon('heroicon-m-bell')
                ->color($pendingTables > 0 ? 'danger' : 'gray'),

            // --- RIGA 2: ALLOGGI (Gestione Stanze) ---
            Stat::make('Arrivi Stanze', Booking::whereDate('check_in', $today)->where('status', 'confirmed')->count() ?? 0)
                ->description('Check-in di oggi')
                ->descriptionIcon('heroicon-m-key') 
                ->color('success'),

            Stat::make('Partenze Stanze', Booking::whereDate('check_out', $today)->count() ?? 0)
                ->description('Libera / Pulizia')
                ->descriptionIcon('heroicon-m-arrow-right-on-rectangle')
                ->color('danger'),

            Stat::make('Stanze Pendenti', $pendingRooms)
                ->description($pendingRooms > 0 ? 'Richieste in attesa' : 'Nessuna pendenza')
                ->descriptionIcon('heroicon-m-exclamation-circle')
                ->color($pendingRooms > 0 ? 'danger' : 'gray'),
        ];
    }
}
