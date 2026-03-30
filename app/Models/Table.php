<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Table extends Model
{
    protected $fillable = [
        'name',
        'table_number', 
        'min_capacity', 
        'max_capacity', 
        'dining_area_id', 
        'is_active'
    ];

    /**
     * Relazione: Il tavolo appartiene a una Sala (Zona)
     */
    public function diningArea(): BelongsTo
    {
        return $this->belongsTo(DiningArea::class);
    }
}
