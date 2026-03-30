<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\TableBooking;
use App\Models\Room;
use App\Models\Table;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        // Pulizia opzionale (rimuovi il commento se vuoi svuotare prima di seminare)
        // Booking::truncate();
        // TableBooking::truncate();

        // --- 1. PRENOTAZIONI ALLOGGI (3 Settimane) ---
        // Generiamo 15 prenotazioni spalmate sui prossimi 21 giorni
        for ($i = 1; $i <= 15; $i++) {
            $checkIn = now()->addDays(rand(0, 18)); // Inizio entro i prossimi 18 gg
            $duration = rand(2, 4); // Soggiorni di 2-4 giorni
            
            Booking::create([
                'room_id' => Room::inRandomOrder()->first()->id,
                'customer_name' => fake()->name(),
                'customer_email' => fake()->unique()->safeEmail(),
                'check_in' => $checkIn->toDateString(),
                'check_out' => $checkIn->copy()->addDays($duration)->toDateString(),
                'status' => 'confirmed',
            ]);
        }

        // --- 2. PRENOTAZIONI TAVOLI (3 Settimane) ---
        // Generiamo 40 prenotazioni per avere i tavoli belli pieni
        $slots = ['pranzo', 'cena'];
        
        for ($i = 1; $i <= 40; $i++) {
            TableBooking::create([
                'table_id' => Table::inRandomOrder()->first()->id,
                'customer_name' => fake()->name(),
                'customer_email' => fake()->unique()->safeEmail(),
                'customer_phone' => '333' . rand(1000000, 9999999),
                'booking_date' => now()->addDays(rand(0, 21))->toDateString(), // Copre 3 settimane
                'slot' => $slots[array_rand($slots)], 
                'people_count' => rand(2, 8),
                'status' => 'confirmed',
            ]);
        }
    }
}
