<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TableBooking extends Model
{
    protected $fillable = [
    'customer_name', 
    'phone', 
    'pax', 
    'reservation_time', 
    'table_id', 
    'notes',
    'table_id',
    'customer_email', // Questo mancava sicuramente
    'booking_date',
    'slot',
    'people_count',
    'status', 
];


    public function table(): BelongsTo
    {
        return $this->belongsTo(Table::class);
    }
}