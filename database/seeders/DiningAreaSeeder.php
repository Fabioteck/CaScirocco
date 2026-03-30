<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DiningAreaSeeder extends Seeder
{
    public function run(): void
{
    $areas = [
        ['name' => 'Sala Camino A (PT)'],
        ['name' => 'Sala Camino B (PT)'],
        ['name' => 'Sala Principale (PT)'],
        ['name' => 'Sala Superiore (P1)'],
        ['name' => 'Area Esterna'],
    ];

        foreach ($areas as $area) {
        $diningArea = \App\Models\DiningArea::create($area);
        
        for ($i = 1; $i <= 3; $i++) {
            \App\Models\Table::create([
                'dining_area_id' => $diningArea->id,
                'name' => "Tavolo " . $i,
                'min_capacity' => 2,        // Valore minimo obbligatorio
                'max_capacity' => rand(4, 8), // Immagino esista anche questa colonna
            ]);
        }
    }

}

}
