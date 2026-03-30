<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Dish;

class DishSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pulizia totale per evitare errori di colonne mancanti o duplicati
        Dish::truncate();

        $menu = [
            'Antipasti' => [
                ['Tagliere Ca\' Scirocco', 'Selezione di salumi locali e formaggi di malga', 14.00],
                ['Crostone della Terra', 'Pane bruscato con funghi trifolati e lardo', 10.00],
                ['Sformatino di Stagione', 'Flan di verdure dell\'orto con crema al parmigiano', 9.00],
                ['Polenta e Schie', 'Polentina morbida con gamberetti di laguna fritti', 12.00],
                ['Bruschette Miste', 'Pomodoro fresco, basilico e olio extravergine', 8.00],
            ],
            'Primi' => [
                ['Bigoli al Ragù d\'Anatra', 'Pasta fresca fatta in casa con ragù bianco d\'anatra', 13.00],
                ['Risotto ai Funghi', 'Riso Vialone Nano con funghi freschi di bosco', 14.00],
                ['Gnocchi di Patate', 'Gnocchi fatti a mano con burro versato e salvia', 11.00],
                ['Tagliatelle al Tartufo', 'Pasta all\'uovo con scaglie di tartufo nero', 16.00],
                ['Zuppa del Contadino', 'Minestrone di legumi e cereali della nostra terra', 10.00],
            ],
            'Secondi' => [
                ['Grigliata Mista', 'Costicine, salsiccia e coppa di maiale ai ferri', 18.00],
                ['Tagliata di Manzo', 'Controfiletto con rucola e scaglie di grana', 20.00],
                ['Spezzatino con Polenta', 'Carne tenera stufata lentamente con vino rosso', 15.00],
                ['Faraona al Forno', 'Coscia di faraona con aromi dell\'orto', 16.00],
                ['Formaggio alla Piastra', 'Dobbiaco fuso servito con verdure grigliate', 13.00],
            ],
            'Dessert' => [
                ['Tiramisù della Casa', 'Ricetta classica con savoiardi e mascarpone fresco', 6.00],
                ['Crostata di Marmellata', 'Pasta frolla burrosa con confettura di albicocche', 5.00],
                ['Panna Cotta', 'Con frutti di bosco caldi o caramello', 5.50],
                ['Salame al Cioccolato', 'Servito con crema inglese fatta in casa', 5.00],
                ['Semifreddo all\'Amaretto', 'Dolce al cucchiaio con granella di amaretti', 6.00],
            ]
        ];

        foreach ($menu as $categoria => $piatti) {
            foreach ($piatti as $dati) {
                Dish::create([
                    'name'        => $dati[0],
                    'description' => $dati[1],
                    'price'       => $dati[2],
                    'category'    => $categoria,
                    // Se 'is_active' ti dà ancora errore, commenta la riga qui sotto
                    'is_active'   => true, 
                    'allergens'   => 'Contiene glutine, lattosio',
                ]);
            }
        }
    }
}
