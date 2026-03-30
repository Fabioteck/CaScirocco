<?php

namespace App\Mail;

use App\Models\Booking; // Importiamo il modello per pulizia
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;


class BookingConfirmed extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     * Nota: rimosse le doppie parentesi e le graffe extra
     */
    public function __construct(public Booking $booking) 
    {
        // Qui non serve scrivere nulla, la variabile $booking è già disponibile
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Conferma Prenotazione - Ca\' Scirocco', // Un oggetto più professionale
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.booking-confirmed',
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}
