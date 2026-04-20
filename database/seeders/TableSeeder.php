<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    for ($i = 1; $i <= 10; $i++) {
        \App\Models\Table::create([
            'name' => "Tavolo $i",
            'min_capacity' => 2,
            'max_capacity' => 4, // Supponiamo tavoli da 4
        ]);
    }
}

}
