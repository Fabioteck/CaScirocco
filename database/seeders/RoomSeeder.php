<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        $rooms = [
            ['name' => 'Stanza Scirocco', 'capacity' => 2, 'price_per_night' => 85.00],
            ['name' => 'Stanza Tramontana', 'capacity' => 2, 'price_per_night' => 90.00],
            ['name' => 'Stanza Libeccio', 'capacity' => 3, 'price_per_night' => 110.00],
            ['name' => 'Stanza Grecale', 'capacity' => 4, 'price_per_night' => 130.00],
        ];

        foreach ($rooms as $room) {
            DB::table('rooms')->insert([
                'name' => $room['name'],
                'capacity' => $room['capacity'],
                'price_per_night' => $room['price_per_night'],
                'images' => json_encode([]), // Trasformiamo l'array in stringa JSON per SQLite
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
