<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f5f5f4; margin: 0; padding: 0; }
        .wrapper { width: 100%; background-color: #f5f5f4; padding: 40px 0; }
        .container { max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .header { background-color: #1c1917; padding: 40px; text-align: center; border-bottom: 4px solid #b45309; }
        .header h1 { color: #ffffff; font-size: 28px; margin: 0; text-transform: uppercase; letter-spacing: 3px; font-weight: 300; }
        .content { padding: 40px; color: #44403c; line-height: 1.6; }
        .content h2 { color: #b45309; font-size: 18px; margin-top: 0; text-transform: uppercase; letter-spacing: 2px; }
        .details-box { background-color: #fafaf9; border: 1px dashed #d6d3d1; border-radius: 4px; padding: 25px; margin: 30px 0; }
        .details-row { margin-bottom: 12px; font-size: 15px; border-bottom: 1px solid #f5f5f4; padding-bottom: 8px; }
        .details-row:last-child { border-bottom: none; }
        .details-label { font-weight: bold; color: #78716c; width: 120px; display: inline-block; text-transform: uppercase; font-size: 12px; }
        .button-container { text-align: center; margin: 40px 0 20px; }
        .button { background-color: #1c1917; color: #ffffff !important; padding: 14px 28px; text-decoration: none; border-radius: 2px; font-weight: bold; font-size: 13px; text-transform: uppercase; letter-spacing: 2px; border: 1px solid #b45309; }
        .footer { padding: 30px; text-align: center; font-size: 11px; color: #a8a29e; background-color: #fafaf9; }
        .footer a { color: #b45309; text-decoration: none; font-weight: bold; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <div class="header">
                <h1>Cà Scirocco</h1>
                <p style="color: #b45309; font-size: 10px; letter-spacing: 5px; text-transform: uppercase; margin-top: 10px; font-weight: bold;">Ristorante</p>
            </div>

            <div class="content">
                <h2>Tavolo Confermato</h2>
                
                <p>Gentile <strong>{{ $booking->customer_name }}</strong>,</p>
                <p>{{ $customText ?? "È un piacere confermare la tua prenotazione. La nostra cucina è pronta a farti scoprire i sapori autentici della tradizione veneta e del Delta del Po." }}</p>

                <div class="details-box">
                    <div class="details-row">
                        <span class="details-label">Data:</span> {{ \Carbon\Carbon::parse($booking->booking_date)->format('d/m/Y') }}
                    </div>
                    <div class="details-row">
                        <span class="details-label">Turno:</span> {{ ucfirst($booking->slot) }}
                    </div>
                    <div class="details-row">
                        <span class="details-label">Coperti:</span> {{ $booking->people_count }} persone
                    </div>
                    <div class="details-row">
                        <span class="details-label">Tavolo:</span> {{ $booking->table->name ?? 'Assegnazione automatica' }}
                    </div>
                </div>

                <p style="font-size: 13px; font-style: italic; color: #78716c;">
                    Ti preghiamo di segnalarci eventuali allergie o intolleranze alimentari in fase di arrivo. In caso di ritardo superiore ai 20 minuti, ti invitiamo a contattarci telefonicamente.
                </p>

                <div class="button-container">
                    <a href="https://maps.app.goo.gl..." class="button">Vieni a trovarci</a>
                </div>
            </div>

            <div class="footer">
                <p>Cà Scirocco — Via Scirocco, 12 — Adria (RO)<br>Prenotazioni: +39 0425 123 456</p>
                <p style="margin-top: 20px;">
                    Seguici su <a href="https://facebook.com...">Facebook</a> e <a href="https://instagram.com...">Instagram</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
