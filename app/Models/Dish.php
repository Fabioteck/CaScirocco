<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dish extends Model
{
    use HasFactory;

    /**
     * Campi autorizzati per il salvataggio di massa.
     * Aggiungi qui ogni nuova colonna che crei nel database.
     */
     protected $guarded = [];
    /**
     * Relazione con le selezioni del menù del giorno.
     */
    public function dailySelections(): HasMany
    {
        return $this->hasMany(DailyMenuSelection::class);
    }
}
