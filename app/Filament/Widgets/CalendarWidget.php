<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use App\Models\TableBooking;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use Illuminate\Support\Carbon;

class CalendarWidget extends FullCalendarWidget
{
    protected static ?int $sort = 3; 

    public function fetchEvents(array $fetchInfo): array
    {
        // Palette 4 Toni di Blu/Azzurro per le stanze confermate
        $roomColors = [
            'Scirocco'  => '#3b82f6', // Blu medio
            'Maestrale' => '#2563eb', // Blu scuro
            'Libeccio'  => '#60a5fa', // Azzurro
            'Grecale'   => '#93c5fd', // Azzurro pastello
        ];

        // 1. PRENOTAZIONI STANZE
        $roomEvents = Booking::query()
            ->whereIn('status', ['confirmed', 'pending'])
            ->get()
            ->map(function (Booking $booking) use ($roomColors) {
                
                // Se è pending => ROSSO, se confermata => BLU della stanza
                $color = ($booking->status === 'pending') 
                    ? '#ef4444' 
                    : ($roomColors[$booking->room_name] ?? '#1e40af');

                return [
                    'id' => "room_{$booking->id}",
                    'title' => "🏨 {$booking->room_name}: {$booking->customer_name}",
                    'start' => $booking->check_in,
                    'end' => Carbon::parse($booking->check_out)->addDay()->toDateString(), 
                    'color' => $color,
                    'url' => \App\Filament\Resources\BookingResource::getUrl('edit', ['record' => $booking]),
                ];
            });

        // 2. PRENOTAZIONI TAVOLI
        $tableEvents = TableBooking::query()
            ->whereIn('status', ['confirmed', 'pending'])
            ->get()
            ->map(function (TableBooking $tableBooking) {
                $icon = $tableBooking->slot === 'pranzo' ? '☀️' : '🌙';
                
                // Verde se confermato, Rosso se pending
                $color = ($tableBooking->status === 'confirmed') ? '#22c55e' : '#ef4444';

                return [
                    'id' => "table_{$tableBooking->id}",
                    'title' => "{$icon} {$tableBooking->customer_name} ({$tableBooking->people_count}p)",
                    'start' => $tableBooking->booking_date,
                    'allDay' => true,
                    'color' => $color,
                    'url' => \App\Filament\Resources\TableBookingResource::getUrl('edit', ['record' => $tableBooking]),
                ];
            });

        return $roomEvents->concat($tableEvents)->toArray();
    }

    public static function canView(): bool
            {
                // Ritorna false così sparisce dalla Dashboard, 
                // ma resta attivo nella pagina dedicata 'Calendario'
                return false; 
            }

}
