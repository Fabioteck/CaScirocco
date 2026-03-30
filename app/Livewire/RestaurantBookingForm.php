<?php
namespace App\Livewire;

use App\Models\TableBooking;
use App\Models\Table;
use Livewire\Component;

class RestaurantBookingForm extends Component
{
    public $booking_date, $slot = 'cena', $people_count = 2, $customer_name, $customer_email;
    public $message = '';

    // Supponiamo che il ristorante abbia 40 coperti totali
    const MAX_CAPACITY = 40;

    public function submit()
    {
        $this->validate([
            'booking_date' => 'required|date|after_or_equal:today',
            'slot' => 'required',
            'people_count' => 'required|integer|min:1|max:10',
            'customer_name' => 'required',
            'customer_email' => 'required|email',
        ]);

        // Calcoliamo quanti coperti sono già occupati per quel giorno e quel turno
        $alreadyBooked = TableBooking::where('booking_date', $this->booking_date)
            ->where('slot', $this->slot)
            ->where('status', 'confirmed')
            ->sum('people_count');

        if (($alreadyBooked + $this->people_count) > self::MAX_CAPACITY) {
            $this->message = "Spiacenti, per il turno di {$this->slot} siamo al completo.";
            return;
        }

        // Assegniamo un tavolo casuale tra quelli che hanno la capienza adatta (logica semplificata)
        $table = Table::where('max_capacity', '>=', $this->people_count)->first();

        TableBooking::create([
            'table_id' => $table ? $table->id : 1,
            'customer_name' => $this->customer_name,
            'customer_email' => $this->customer_email,
            'booking_date' => $this->booking_date,
            'slot' => $this->slot,
            'people_count' => $this->people_count,
            'status' => 'pending',
        ]);

        $this->message = "Richiesta ricevuta! Ti aspettiamo per {$this->slot}.";
        $this->reset(['customer_name', 'customer_email']);
    }

    public function render()
    {
        return view('livewire.restaurant-booking-form');
    }
}