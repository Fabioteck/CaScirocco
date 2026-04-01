<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    /**
     * I campi che possono essere assegnati massivamente.
     * Necessario per far funzionare i form di Filament.
     */
    protected $fillable = [
        'name',
        'slug',
        'capacity',
        'price_per_night',
        'images', // Se usi il campo JSON direttamente nella tabella rooms
        'description',
        'size_sqm',
        'bed_type',
        'bathroom_type',
        'amenities',
    ];

    /**
     * Trasforma automaticamente la stringa JSON del database in un array PHP.
     * Fondamentale per l'upload multiplo di Filament.
     */
    protected $casts = [
        'images' => 'array',
        'price_per_night' => 'decimal:2',
        'amenities' => 'array',
    ];

    /**
     * Relazione con le prenotazioni.
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Se hai deciso di usare una tabella separata per le immagini (RoomImage),
     * questa relazione è corretta. Se invece usi il campo JSON 'images' 
     * direttamente nella tabella 'rooms', questa funzione non ti serve.
     */
    public function room_images(): HasMany
    {
        return $this->hasMany(RoomImage::class);
    }
}
