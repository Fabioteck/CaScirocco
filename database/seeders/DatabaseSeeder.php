<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Dish;
use App\Models\Wine;
use App\Models\Room;
use App\Models\DiningArea;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 0. DISABILITA CONTROLLI CHIAVI ESTERNE (Per SQLite)
    \Illuminate\Support\Facades\DB::statement('PRAGMA foreign_keys = OFF');

    // 1. PULIZIA TOTALE (Svuota tutto senza errori)
    \App\Models\DailyDish::truncate();
    \App\Models\TableBooking::truncate(); // Assicurati che il nome modello sia corretto
    \App\Models\Booking::truncate();
    \App\Models\Dish::truncate();
    \App\Models\Wine::truncate();
    \App\Models\Room::truncate();
    \App\Models\DiningArea::truncate();

    // RIABILITA CONTROLLI CHIAVI ESTERNE
    \Illuminate\Support\Facades\DB::statement('PRAGMA foreign_keys = ON');

        // --- 1. PIATTI (MENÙ STAGIONALE - 25 PORTATE) ---
        $piatti = [
            'Antipasti' => [
                ['Tagliere Ca\' Scirocco', 'Salumi e formaggi del territorio', 14.00],
                ['Crostone ai Funghi', 'Pane bruscato e funghi trifolati', 10.00],
                ['Polentina e Schie', 'Gamberetti di laguna fritti', 12.00],
                ['Sformatino di Verdure', 'Flan di stagione con crema grana', 9.00],
                ['Bruschette Miste', 'Pomodoro, basilico e sapori dell\'orto', 8.00],
            ],
            'Primi' => [
                ['Bigoli all\'Anatra', 'Pasta fresca con ragù d\'anatra bianco', 13.00],
                ['Risotto ai Funghi', 'Vialone Nano con funghi di bosco', 14.00],
                ['Gnocchi di Patate', 'Fatti in casa con burro e salvia', 11.00],
                ['Tagliatelle al Tartufo', 'Pasta all\'uovo con tartufo nero', 16.00],
                ['Zuppa del Giorno', 'Cereali e legumi della nostra terra', 10.00],
            ],
            'Secondi' => [
                ['Grigliata Mista', 'Costicine, salsiccia e coppa ai ferri', 18.00],
                ['Tagliata di Manzo', 'Con rucola e scaglie di grana', 20.00],
                ['Spezzatino con Polenta', 'Carne stufata al vino rosso', 15.00],
                ['Faraona al Forno', 'Coscia di faraona agli aromi', 16.00],
                ['Formaggio alla Piastra', 'Dobbiaco fuso con verdure', 13.00],
            ],
            'Contorni' => [
                ['Patate al Forno', 'Croccanti al rosmarino', 5.00],
                ['Verdure alla Griglia', 'Melanzane, zucchine e peperoni', 6.00],
                ['Erbette di Campo', 'Saltate in padella con aglio e olio', 5.00],
                ['Insalata Mista', 'Fresca di stagione dall\'orto', 4.50],
                ['Fagioli in Salsa', 'Cucinati lentamente come una volta', 5.00],
            ],
            'Dessert' => [
                ['Tiramisù', 'Ricetta classica della casa', 6.00],
                ['Crostata', 'Frolla con confettura di albicocche', 5.00],
                ['Panna Cotta', 'Ai frutti di bosco o caramello', 5.50],
                ['Salame al Cioccolato', 'Con crema inglese', 5.00],
                ['Semifreddo', 'All\'amaretto e granella', 6.00],
            ]
        ];

        foreach ($piatti as $cat => $items) {
            foreach ($items as $p) {
                Dish::create(['name' => $p[0], 'description' => $p[1], 'price' => $p[2], 'category' => $cat, 'is_active' => true, 'is_daily' => false]);
            }
        }

        // --- 2. VINI (CANTINA - 20 ETICHETTE) ---
                // --- 2. VINI (CANTINA - 20 ETICHETTE) ---
        $vini = [
            ['Prosecco Superiore', 'DOCG', 'Valdobbiadene', 'Bollicine', 22.00],
            ['Franciacorta Brut', 'DOCG', 'Lombardia', 'Bollicine', 35.00],
            ['Champagne Réserve', 'AOC', 'Francia', 'Bollicine', 65.00],
            ['Ribolla Gialla', 'IGT', 'Friuli', 'Bianco', 18.00],
            ['Lugana', 'DOC', 'Lago di Garda', 'Bianco', 20.00],
            ['Gewürztraminer', 'DOC', 'Alto Adige', 'Bianco', 24.00],
            ['Chardonnay', 'DOC', 'Veneto', 'Bianco', 16.00],
            ['Pinot Grigio', 'DOC', 'Veneto', 'Bianco', 15.00],
            ['Sauvignon Blanc', 'DOC', 'Friuli', 'Bianco', 22.00],
            ['Amarone della Valpolicella', 'DOCG', 'Veneto', 'Rosso', 55.00],
            ['Valpolicella Ripasso', 'DOC', 'Veneto', 'Rosso', 28.00],
            ['Barolo', 'DOCG', 'Piemonte', 'Rosso', 60.00],
            ['Chianti Classico', 'DOCG', 'Toscana', 'Rosso', 25.00],
            ['Brunello di Montalcino', 'DOCG', 'Toscana', 'Rosso', 75.00],
            ['Primitivo di Manduria', 'DOC', 'Puglia', 'Rosso', 19.00],
            ['Nebbiolo', 'DOC', 'Piemonte', 'Rosso', 26.00],
            ['Cabernet Sauvignon', 'DOC', 'Veneto', 'Rosso', 18.00],
            ['Merlot Riserva', 'DOC', 'Veneto', 'Rosso', 17.00],
            ['Syrah', 'DOC', 'Sicilia', 'Rosso', 21.00],
            ['Lagrein', 'DOC', 'Alto Adige', 'Rosso', 23.00],
        ];

        foreach ($vini as $v) {
            \App\Models\Wine::create([
                'name'           => $v[0],
                'classification' => $v[1], // Aggiunto per risolvere l'errore SQL
                'region'         => $v[2],
                'type'           => $v[3],
                'price_bottle'   => $v[4],
                'producer'       => "Cantina Ca' Scirocco",
                // 'is_active'      => true,
            ]);
        }


        // --- 3. STANZE (ROOMS) ---
        $stanze = [
    ['Scirocco', 120.00], 
    ['Grecale', 95.00],
    ['Libeccio', 80.00], 
    ['Tramontana', 60.00],
        ];

        foreach ($stanze as $r) {
            \App\Models\Room::create([
                'name'            => $r[0],
                'price_per_night' => $r[1],
                'is_active'    => true,
            ]);
        }

        // --- 4. AREE RISTORANTE (DINING AREAS) ---
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
