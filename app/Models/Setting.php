<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    /**
     * I campi che possono essere scritti nel database.
     * Senza questo, Laravel blocca il salvataggio per sicurezza.
     */
    protected $fillable = [
        'key',
        'value',
    ];
}