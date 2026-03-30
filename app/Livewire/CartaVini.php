<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Wine;

class CartaVini extends Component
{
        public function render()
{
    return view('livewire.carta-vini', [
        // Raggruppiamo i vini per tipologia (Rossi, Bianchi, ecc.)
        'collezioneVini' => \App\Models\Wine::where('is_available', true)
            ->orderBy('type')
            ->get()
            ->groupBy('type')
    ]);
}

}
