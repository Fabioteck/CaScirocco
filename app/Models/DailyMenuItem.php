<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DailyMenuItem extends Model
{
    // Specifichiamo la tabella se Laravel non la trova in automatico
    protected $table = 'daily_menu_items';

    protected $fillable = [
        'dish_id',
        'custom_name',
        'custom_price',
        'menu_date'
    ];

    protected $casts = [
        'menu_date' => 'date',
    ];

    /**
     * Relazione: Ogni voce del menù del giorno punta a un piatto originale.
     */
    public function dish(): BelongsTo
    {
        return $this->belongsTo(Dish::class);
    }
}
