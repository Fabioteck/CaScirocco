<?php

namespace App\Mail;

use App\Models\TableBooking; // Assicurati che importi il modello corretto
use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;
use Illuminate\Contracts\Queue\ShouldQueue;


class TableBookingConfirmed extends Mailable implements ShouldQueue 
{
    use Queueable, SerializesModels;

    public function __construct(public TableBooking $booking) {}

    public function envelope(): Envelope
{
    $subject = \App\Models\Setting::where('key', 'email_restaurant_subject')->value('value') 
               ?? 'Conferma Tavolo - Ca\' Scirocco';

    return new Envelope(subject: $subject);
}

public function content(): Content
{
    $body = \App\Models\Setting::where('key', 'email_restaurant_body')->value('value') 
            ?? 'La tua prenotazione del tavolo è confermata.';

    // Sostituiamo i tag dinamici
    $finalBody = str_replace(
        ['{customer_name}', '{people_count}'], 
        [$this->booking->customer_name, $this->booking->people_count], 
        $body
    );

    return new Content(
        view: 'emails.table-confirmed',
        with: ['body' => $finalBody],
    );
}

}
