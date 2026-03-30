<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Wine extends Model
{
    // Campi riempibili (Mass Assignment)
    protected $fillable = [
        'name', 'producer', 'vintage', 'type', 'classification', 'grapes', 
        'alcohol_pct', 'country', 'region', 'sub_zone', 'format', 
        'price_bottle', 'price_glass', 'supplier_cost', 'sku', 'stock', 
        'is_available', 'tasting_notes', 'body', 'sensory_profile', 
        'storytelling', 'label_image', 'nutritional_info'
    ];

    // Cast per i campi JSON o decimali complessi
    protected $casts = [
        'is_available' => 'boolean',
        'sensory_profile' => 'array',
        'nutritional_info' => 'array',
        'alcohol_pct' => 'decimal:1',
    ];

    /**
     * Relazione: Un vino può essere consigliato in molti piatti del giorno.
     */
    public function suggestedInDishes(): HasMany
    {
        return $this->hasMany(DailyDish::class, 'suggested_wine_id');
    }
}
