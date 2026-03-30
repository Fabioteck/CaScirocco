<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Wine;
use Illuminate\Http\Request;

class WineController extends Controller
{
    // Lista di tutti i vini con paginazione
    public function index()
    {
        $wines = Wine::orderBy('type')->orderBy('name')->paginate(15);
        return view('admin.wines.index', compact('wines'));
    }

    // Salvataggio nuovo vino
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'producer' => 'required|string',
            'price_bottle' => 'required|numeric',
            'type' => 'required', // Rosso, Bianco, ecc.
            'stock' => 'integer|min:0',
        ]);

        Wine::create($request->all()); // Usiamo all() perché abbiamo il $fillable nel Model
        return redirect()->back()->with('success', 'Vino aggiunto in cantina!');
    }

    // Aggiornamento rapido (es. per lo stock o disponibilità via AJAX/Livewire)
    public function update(Request $request, Wine $wine)
    {
        $wine->update($request->all());
        return redirect()->route('admin.wines.index')->with('success', 'Scheda vino aggiornata.');
    }
}
