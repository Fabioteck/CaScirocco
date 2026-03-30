<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str; 

class Category extends Model
{
    protected $fillable = ['name', 'slug'];

    /**
     * Boot del modello per intercettare il salvataggio
     */
    protected static function booted()
    {
        static::creating(function ($category) {
            // Se lo slug non è già stato inserito manualmente, lo generiamo dal nome
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });

        static::updating(function ($category) {
            // Opzionale: aggiorna lo slug se il nome cambia
            $category->slug = Str::slug($category->name);
        });
    }

    public function galleries() 
    {
        return $this->hasMany(Gallery::class);
    }
}

