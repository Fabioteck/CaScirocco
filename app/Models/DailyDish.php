<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DailyDish extends Model
{
    protected $fillable = [
        'name', 'category', 'description', 'price', 'allergens', 
        'dietary_tags', 'is_out_of_stock', 'image_path', 
        'suggested_wine_id', 'menu_date', 'is_active'
    ];

    protected $casts = [
        'allergens' => 'array',
        'dietary_tags' => 'array',
        'is_out_of_stock' => 'boolean',
        'is_active' => 'boolean',
        'menu_date' => 'date',
    ];

    /**
     * Relazione: Il "Ponte". Il piatto appartiene a un vino suggerito.
     */
    public function suggestedWine(): BelongsTo
    {
        return $this->belongsTo(Wine::class, 'suggested_wine_id');
    }
}
