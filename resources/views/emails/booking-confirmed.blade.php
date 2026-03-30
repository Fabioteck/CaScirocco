<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f5f5f4; margin: 0; padding: 0; -webkit-font-smoothing: antialiased; }
        .wrapper { width: 100%; background-color: #f5f5f4; padding: 40px 0; }
        .container { max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .header { background-color: #1c1917; padding: 40px; text-align: center; }
        .header h1 { color: #ffffff; font-family: 'Playfair Display', serif; font-style: italic; font-size: 32px; margin: 0; text-transform: uppercase; letter-spacing: 2px; }
        .content { padding: 40px; color: #44403c; line-height: 1.6; }
        .content h2 { color: #b45309; font-size: 20px; margin-top: 0; text-transform: uppercase; letter-spacing: 1px; }
        .details-box { background-color: #fffbeb; border: 1px solid #fef3c7; border-radius: 6px; padding: 25px; margin: 30px 0; }
        .details-row { margin-bottom: 10px; font-size: 15px; }
        .details-label { font-weight: bold; color: #92400e; width: 100px; display: inline-block; }
        .button-container { text-align: center; margin: 40px 0 20px; }
        .button { background-color: #b45309; color: #ffffff !important; padding: 16px 32px; text-decoration: none; border-radius: 4px; font-weight: bold; font-size: 14px; text-transform: uppercase; letter-spacing: 1px; }
        .footer { padding: 30px; text-align: center; font-size: 12px; color: #a8a29e; background-color: #fafaf9; border-top: 1px solid #f5f5f4; }
        .footer a { color: #b45309; text-decoration: none; margin: 0 10px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <!-- Header con Brand -->
            <div class="header">
                <h1>Cà Scirocco</h1>
                <p style="color: #d6d3d1; font-size: 10px; letter-spacing: 4px; text-transform: uppercase; margin-top: 10px;">Natura & Tradizione</p>
            </div>

            <!-- Contenuto -->
            <div class="content">
                <h2>Conferma Prenotazione</h2>
                
                {{-- Qui iniettiamo il testo dinamico dal database --}}
                <p>Gentile <strong>{{ $booking->customer_name }}</strong>,</p>
                <p>{{ $customText ?? "Siamo lieti di confermare il tuo soggiorno presso la nostra tenuta. Il Delta del Po e l'atmosfera di Cà Scirocco sono pronti ad accoglierti per un'esperienza di autentico relax." }}</p>

                <!-- Box Dettagli -->
                <div class="details-box">
                    <div class="details-row">
                        <span class="details-label">Alloggio:</span> {{ $booking->room->name ?? 'Stanza riservata' }}
                    </div>
                    <div class="details-row">
                        <span class="details-label">Arrivo:</span> {{ \Carbon\Carbon::parse($booking->check_in)->format('d/m/Y') }}
                    </div>
                    <div class="details-row">
                        <span class="details-label">Partenza:</span> {{ \Carbon\Carbon::parse($booking->check_out)->format('d/m/Y') }}
                    </div>
                    <div class="details-row">
                        <span class="details-label">Ospiti:</span> {{ $booking->people_count ?? '1' }} persone
                    </div>
                </div>

                <p>Ti ricordiamo che il check-in è disponibile dalle ore 14:00. Se hai esigenze particolari o desideri prenotare un tavolo al nostro ristorante, non esitare a contattarci.</p>

                <!-- Bottone CTA -->
                <div class="button-container">
                    <a href="https://maps.app.goo.gl..." class="button">Ottieni indicazioni</a>
                </div>
            </div>

            <!-- Footer -->
            <div class="footer">
                <p>Via Scirocco, 12 — Adria (RO)<br>+39 0425 123 456 | info@cascirocco.it</p>
                <div style="margin-top: 20px;">
                    <a href="https://facebook.com">Facebook</a> | 
                    <a href="https://instagram.com">Instagram</a>
                </div>
                <p style="margin-top: 30px; font-size: 10px;">&copy; {{ date('Y') }} Cà Scirocco. Tutti i diritti riservati.</p>
            </div>
        </div>
    </div>
</body>
</html>
