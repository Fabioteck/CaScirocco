<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Fondamentale per la relazione
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingConfirmed;

class Booking extends Model
{
    /**
     * Permettiamo a Laravel di salvare questi campi dal form
     */
    protected $fillable = [
        'room_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'check_in',
        'check_out',
        'guests_count',
        'status',
        'notes',
    ];

    /**
     * Logica automatica per l'invio delle email
     */
    protected static function booted()
    {
        static::updated(function ($booking) {
            // Se lo stato è cambiato in 'confirmed' proprio ora
            if ($booking->wasChanged('status') && $booking->status === 'confirmed') {
                Mail::to($booking->customer_email)->send(new BookingConfirmed($booking));
            }
        });
    }

    /**
     * Relazione con la stanza
     * Questo risolve l'errore "Relation must be of type Relation, null given"
     */
    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }
}
