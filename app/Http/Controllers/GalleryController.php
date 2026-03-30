<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        // Recuperiamo le categorie con le loro foto associate
        // Usiamo with('galleries') per caricare tutto in una singola query
        $categories = Category::with(['galleries' => function($query) {
            $query->orderBy('sort_order', 'asc'); // Ordiniamo le foto se hai aggiunto il campo
        }])->has('galleries') // Mostriamo solo categorie che hanno almeno una foto
           ->get();

        return view('gallery.index', compact('categories'));
    }
}
