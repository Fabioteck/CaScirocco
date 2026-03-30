<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiningArea extends Model
{
    // Questa riga permette a Laravel di scrivere nel database
    protected $fillable = ['name'];

    public function tables()
    {
        return $this->hasMany(Table::class);
    }
}
