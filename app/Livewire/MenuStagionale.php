<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Dish;

class MenuStagionale extends Component
{
     // app/Livewire/MenuStagionale.php

// app/Livewire/MenuStagionale.php

public function render()
{
    return view('livewire.menu-stagionale', [
        'dishes' => \App\Models\Dish::where('is_active', true)->get()->groupBy('category'),
    ]);
}

}
