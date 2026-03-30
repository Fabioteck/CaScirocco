<?php

use App\Models\Room; 
use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\Admin\WineController;
use App\Http\Controllers\Admin\DailyDishController;
use App\Livewire\CartaVini;
use App\Livewire\MenuStagionale; 

Route::get('/cantina', CartaVini::class)->name('cantina');
Route::get('/il-menu', MenuStagionale::class)->name('frontend.menu');

Route::get('/menu-digitale', [MenuController::class, 'index'])->name('menu.digitale');

// Rotta per il modulo alloggio
Route::get('/alloggio/{id}', function ($id) {
    $room = Room::findOrFail($id); 
    
    // Passiamo la variabile $room alla pagina di dettaglio
    return view('stanza-dettaglio', compact('room'));
})->name('stanze.show');

// Questa rotta cattura l'ID e lo passa alla pagina di dettaglio
Route::get('/stanza/{id}', function ($id) {
    $room = Room::findOrFail($id); // Se l'ID non esiste, l'app non crasha ma dà 404
    return view('stanza-dettaglio', compact('room'));
})->name('stanza.show');


Route::post('/prenotazione/verifica', [BookingController::class, 'checkAvailability'])->name('bookings.check');

Route::get('/', function () {
    $rooms = \App\Models\Room::all();
    // Recuperiamo i settaggi di chiusura
    $settings = \App\Models\Setting::all()->pluck('value', 'key');
    
    return view('welcome', compact('rooms', 'settings'));
});

Route::get('/test-auth', function () {
    if (Auth::check()) {
        return "Sei loggato come: " . Auth::user()->email;
    }
    return "NON sei loggato.";
})->middleware('web');

Route::get('/privacy-policy', function () { return view('legal.privacy'); })->name('privacy');
Route::get('/cookie-policy', function () { return view('legal.cookies'); })->name('cookies');
Route::get('/termini-condizioni', function () { return view('legal.terms'); })->name('terms');

Route::get('/alloggi/{slug}', function ($slug) {
    $room = \App\Models\Room::where('slug', $slug)->firstOrFail();
    return view('stanza-dettaglio', compact('room'));
})->name('alloggi.show');

use App\Http\Controllers\GalleryController;

Route::get('/galleria', [GalleryController::class, 'index'])->name('gallery.index');




