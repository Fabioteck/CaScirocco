<?php

namespace App\Http\Controllers;

use App\Models\Dish;
use App\Models\Wine;
use App\Models\DailyDish;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    // L'ordine che vogliamo per le portate
    protected $ordineCategorie = ['Antipasti', 'Primi', 'Secondi', 'Contorni', 'Dessert'];

    /**
     * MENÙ DEL GIORNO (Digitale / QR Code)
     */
    public function index()
    {
        $dishes = DailyDish::with('suggestedWine')
            ->where('is_active', true)
            ->whereDate('menu_date', now())
            ->get()
            ->groupBy('category')
            ->sortBy(function ($item, $key) {
                return array_search($key, $this->ordineCategorie);
            });

        $wines = Wine::where('is_available', true)
            ->orderBy('name')
            ->get()
            ->groupBy('type');

        return view('menu.digital', compact('dishes', 'wines'));
    }

    /**
     * MENÙ STAGIONALE (Il menù completo fisso)
     */
    public function stagionale()
{
    $ordineCategorie = ['Antipasti', 'Primi', 'Secondi', 'Contorni', 'Dessert'];

    // Recuperiamo i piatti e li raggruppiamo
    $dishes = \App\Models\Dish::where('is_active', true)
        ->get()
        ->groupBy('category')
        ->sortBy(function ($item, $key) use ($ordineCategorie) {
            $pos = array_search($key, $ordineCategorie);
            return $pos === false ? 99 : $pos;
        });

    // IMPORTANTE: il nome qui deve essere 'dishes'
    return view('livewire.menu-stagionale', compact('dishes'));
}

}
