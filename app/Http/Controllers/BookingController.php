<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking; 
use Carbon\Carbon;

class BookingController extends Controller
{
    public function checkAvailability(Request $request)
        {
            $validated = $request->validate([
                'check_in' => 'required|date|after_or_equal:today',
                'room_type' => 'required|string',
            ]);

            // Cerchiamo se esiste già una prenotazione per quel giorno e quella camera
            $isOccupied = \App\Models\Booking::where('room_name', $validated['room_type'])
                ->where('check_in', '<=', $validated['check_in'])
                ->where('check_out', '>', $validated['check_in'])
                ->where('status', 'confirmed') // Consideriamo solo quelle confermate
                ->exists();

            if ($isOccupied) {
                return back()->with('error', "Spiacenti, la camera {$validated['room_type']} è già occupata per il " . \Carbon\Carbon::parse($validated['check_in'])->format('d/m/Y'));
            }

            return back()->with('success', "Ottimo! La camera {$validated['room_type']} sembra libera. Procedi con la prenotazione!");
        }

}
