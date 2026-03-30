<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Dish;
use App\Models\Wine;
use App\Models\DailyDish;
use App\Models\DailyMenuItem;
use Illuminate\Support\Carbon;

class DailyMenuSeeder extends Seeder
{
    public function run(): void
    {
        // Pulizia tabelle per evitare duplicati se lanci il seeder più volte
        DailyDish::truncate();
        DailyMenuItem::truncate();

        $categorie = ['Antipasti', 'Primi', 'Secondi', 'Contorni', 'Dessert'];
        
        // Ciclo per i prossimi 21 giorni (3 settimane)
        for ($i = 0; $i < 21; $i++) {
            $dataMenu = Carbon::today()->addDays($i);

            foreach ($categorie as $cat) {
                // Prendiamo 2 piatti casuali per ogni categoria per ogni giorno
                $piattiBase = Dish::where('category', $cat)->inRandomOrder()->take(2)->get();
                
                foreach ($piattiBase as $piatto) {
                    // Cerchiamo un vino (magari bianco per antipasti/primi, rosso per secondi)
                    $tipoVino = in_array($cat, ['Antipasti', 'Primi']) ? '%Bianco%' : '%Rosso%';
                    $vino = Wine::where('type', 'like', $tipoVino)->inRandomOrder()->first();

                    DailyDish::create([
                        'name' => $piatto->name,
                        'category' => $piatto->category,
                        'description' => $piatto->description,
                        'price' => $piatto->price,
                        'suggested_wine_id' => $vino ? $vino->id : null,
                        'menu_date' => $dataMenu, // <--- Data dinamica
                        'is_active' => true,
                    ]);

                    DailyMenuItem::create([
                        'dish_id' => $piatto->id,
                        'menu_date' => $dataMenu, // <--- Data dinamica
                    ]);
                }
            }
        }
    }
}
