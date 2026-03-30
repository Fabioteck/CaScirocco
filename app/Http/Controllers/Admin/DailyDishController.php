<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DailyDish;
use App\Models\Wine;
use Illuminate\Http\Request;

class DailyDishController extends Controller
{
    public function index()
    {
        // Prendiamo i piatti di oggi con il loro vino associato (Eager Loading)
        $dishes = DailyDish::with('suggestedWine')
                    ->whereDate('menu_date', now())
                    ->get();
        
        // Ci serve la lista dei vini per il menu a tendina del "Ponte"
        $availableWines = Wine::where('is_available', true)->orderBy('name')->get();

        return view('admin.menu.index', compact('dishes', 'availableWines'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category' => 'required',
            'price' => 'required|numeric',
            'menu_date' => 'required|date',
        ]);

        DailyDish::create($request->all());
        return redirect()->back()->with('success', 'Piatto inserito nel menù.');
    }
}