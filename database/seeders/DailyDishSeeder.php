<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DailyDishSeeder extends Seeder
{
        public function run(): void
{
    $piatti = [
        ['name' => 'Antipasto del Casaro', 'category' => 'Antipasti', 'price' => 12],
        ['name' => 'Risotto ai Funghi', 'category' => 'Primi', 'price' => 15],
        ['name' => 'Tagliata di Manzo', 'category' => 'Secondi', 'price' => 22],
        ['name' => 'Tiramisù della Casa', 'category' => 'Dolci', 'price' => 6],
        ['name' => 'Contorno di Stagione', 'category' => 'Contorni', 'price' => 5],
    ];

    foreach ($piatti as $p) {
        \App\Models\DailyDish::create([
            'name' => $p['name'],
            'category' => $p['category'],
            'price' => $p['price'],
            'menu_date' => now()->toDateString(), // Aggiunta la data obbligatoria (oggi)
        ]);
    }
}


}
