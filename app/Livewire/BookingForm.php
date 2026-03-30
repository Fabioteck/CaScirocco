<?php

namespace App\Livewire;

use App\Models\Booking;
use App\Models\Room;
use App\Models\Setting; // Importante per leggere i settaggi
use Livewire\Component;
use Illuminate\Support\Carbon;

class BookingForm extends Component
{
    public $room_id, $customer_name, $customer_email, $check_in, $check_out;
    public $message = '';

    protected $rules = [
        'room_id' => 'required',
        'customer_name' => 'required|min:3',
        'customer_email' => 'required|email',
        'check_in' => 'required|date|after_or_equal:today',
        'check_out' => 'required|date|after:check_in',
    ];

    public function submit()
    {
        $this->validate();

        // 1. CARICAMENTO SETTAGGI
        $settings = Setting::all()->pluck('value', 'key');
        $checkInDate = Carbon::parse($this->check_in);
        $checkOutDate = Carbon::parse($this->check_out);

        // 2. CONTROLLO CHIUSURA TOTALE (Toggle)
        if ($settings->get('chiusura_totale') === '1') {
            $this->message = "Spiacenti, Ca' Scirocco è temporaneamente chiuso per manutenzione.";
            return;
        }

        // 3. CONTROLLO FERIE (Range di date)
        $ferieInizio = $settings->get('ferie_inizio');
        $ferieFine = $settings->get('ferie_fine');

        if ($ferieInizio && $ferieFine) {
            $inizio = Carbon::parse($ferieInizio);
            $fine = Carbon::parse($ferieFine);

            // Se il check-in o il check-out cadono nel periodo di ferie, blocchiamo
            if ($checkInDate->between($inizio, $fine) || $checkOutDate->between($inizio, $fine)) {
                $this->message = "Spiacenti, siamo chiusi per ferie dal " . $inizio->format('d/m') . " al " . $fine->format('d/m') . ".";
                return;
            }
        }

        // 4. CONTROLLO DISPONIBILITÀ (Overbooking)
        $isOccupied = Booking::where('room_id', $this->room_id)
            ->where('status', 'confirmed')
            ->where(function ($query) {
                $query->whereBetween('check_in', [$this->check_in, $this->check_out])
                      ->orWhereBetween('check_out', [$this->check_in, $this->check_out]);
            })->exists();

        if ($isOccupied) {
            $this->message = "Spiacenti, la stanza è già occupata in queste date.";
            return;
        }

        // 5. CREAZIONE PRENOTAZIONE
        Booking::create([
            'room_id' => $this->room_id,
            'customer_name' => $this->customer_name,
            'customer_email' => $this->customer_email,
            'check_in' => $this->check_in,
            'check_out' => $this->check_out,
            'status' => 'pending',
        ]);

        $this->reset(['room_id', 'customer_name', 'customer_email', 'check_in', 'check_out']);
        $this->message = "Richiesta inviata con successo! Ti risponderemo via email appena possibile.";
    }

    public function render()
    {
        return view('livewire.booking-form', [
            'rooms' => Room::all()
        ]);
    }
}
