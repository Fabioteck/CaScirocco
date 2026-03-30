<?php

namespace Database\Seeders;

use App\Models\Wine;
use Illuminate\Database\Seeder;

class WineSeeder extends Seeder
{
    public function run(): void
    {
        $wines = [
            [
                'name' => 'Sassicaia',
                'producer' => 'Tenuta San Guido',
                'vintage' => '2020',
                'type' => 'Rosso',
                'classification' => 'DOC',
                'region' => 'Toscana',
                'price_bottle' => 290.00,
                'price_glass' => 45.00,
                'stock' => 12,
                'is_available' => true,
                'body' => 5,
            ],
            [
                'name' => 'Franciacorta Cuvée Prestige',
                'producer' => 'Ca\' del Bosco',
                'vintage' => 'NV',
                'type' => 'Bollicine',
                'classification' => 'DOCG',
                'region' => 'Lombardia',
                'price_bottle' => 45.00,
                'price_glass' => 9.00,
                'stock' => 24,
                'is_available' => true,
                'body' => 3,
            ],
            [
                'name' => 'Cervaro della Sala',
                'producer' => 'Antinori',
                'vintage' => '2021',
                'type' => 'Bianco',
                'classification' => 'IGT',
                'region' => 'Umbria',
                'price_bottle' => 65.00,
                'price_glass' => 12.00,
                'stock' => 18,
                'is_available' => true,
                'body' => 4,
            ],
            [
                'name' => 'Amarone della Valpolicella',
                'producer' => 'Quintarelli',
                'vintage' => '2015',
                'type' => 'Rosso',
                'classification' => 'DOCG',
                'region' => 'Veneto',
                'price_bottle' => 350.00,
                'price_glass' => null,
                'stock' => 6,
                'is_available' => true,
                'body' => 5,
            ],
            [
                'name' => 'Ribolla Gialla',
                'producer' => 'Jermann',
                'vintage' => '2022',
                'type' => 'Bianco',
                'classification' => 'IGT',
                'region' => 'Friuli-Venezia Giulia',
                'price_bottle' => 32.00,
                'price_glass' => 7.00,
                'stock' => 30,
                'is_available' => true,
                'body' => 2,
            ],
            [
                'name' => 'Barolo Bussia',
                'producer' => 'Prunotto',
                'vintage' => '2018',
                'type' => 'Rosso',
                'classification' => 'DOCG',
                'region' => 'Piemonte',
                'price_bottle' => 85.00,
                'price_glass' => 15.00,
                'stock' => 10,
                'is_available' => true,
                'body' => 5,
            ],
            [
                'name' => 'Fiano di Avellino',
                'producer' => 'Feudi di San Gregorio',
                'vintage' => '2022',
                'type' => 'Bianco',
                'classification' => 'DOCG',
                'region' => 'Campania',
                'price_bottle' => 28.00,
                'price_glass' => 6.00,
                'stock' => 20,
                'is_available' => true,
                'body' => 3,
            ],
            [
                'name' => 'Giulio Ferrari Riserva del Fondatore',
                'producer' => 'Cantine Ferrari',
                'vintage' => '2012',
                'type' => 'Bollicine',
                'classification' => 'DOC',
                'region' => 'Trentino',
                'price_bottle' => 180.00,
                'price_glass' => null,
                'stock' => 4,
                'is_available' => true,
                'body' => 4,
            ],
            [
                'name' => 'Etna Rosso',
                'producer' => 'Tasca d\'Almerita',
                'vintage' => '2021',
                'type' => 'Rosso',
                'classification' => 'DOC',
                'region' => 'Sicilia',
                'price_bottle' => 38.00,
                'price_glass' => 8.00,
                'stock' => 15,
                'is_available' => true,
                'body' => 3,
            ],
            [
                'name' => 'Vermentino di Gallura',
                'producer' => 'Capichera',
                'vintage' => '2022',
                'type' => 'Bianco',
                'classification' => 'DOCG',
                'region' => 'Sardegna',
                'price_bottle' => 42.00,
                'price_glass' => 9.00,
                'stock' => 12,
                'is_available' => true,
                'body' => 3,
            ],
        ];

        foreach ($wines as $wine) {
            Wine::create($wine);
        }
    }
}
