Integrazione prenotazioni Booking nel pannello admin di fabioteck.me
Obiettivo
Far apparire nel pannello amministrativo (https://www.fabioteck.me/admin/) le prenotazioni che arrivano da Booking.com, mantenendo:

il sistema di prenotazione interno già presente (stanze + tavoli),

il fatto che il cliente accetti solo pagamenti in loco (nessun pagamento online gestito da Booking lato tuo sistema).

Booking resta quindi un canale di prenotazione esterno, mentre il tuo sistema tiene solo una copia “in lettura” delle prenotazioni per visualizzarle e gestirle nello stesso admin.

Come arrivano le prenotazioni da Booking
Booking.com mette a disposizione un’API chiamata Reservations API in formato XML/B.XML.
Le prenotazioni entrano in questo modo:

Tramite chiamate periodiche al servizio XML di Booking (https://secure-supply-xml.booking.com/hotels/xml/reservations).

Il tuo server recupera ogni 20–30 secondi le nuove prenotazioni, modifiche e cancellazioni.

Se il sistema non risponde / non conferma, Booking invia comunque una mail di fallback alla struttura.

Fonte: Booking.com Reservations API – Overview + Retrieving reservations.

Cosa vogliamo fare nel nostro sistema
Importare le prenotazioni Booking nel DB del sito (fabioteck.me), in una tabella separata o con un campo “origine = Booking.com”.

Mostrare queste prenotazioni nello stesso admin delle prenotazioni interne, con:

filtro “Origine: Booking.com” vs “Sito diretto”,

stessa UI per visualizzare dati (check‑in, check‑out, numero persone, stanza, ecc.).

Non gestire il pagamento da Booking lato tuo sistema:

Booking gestisce il pagamento (se il canale è “pagamento al booking”),

ma il cliente vuole pagamento in loco, quindi nel tuo admin la prenotazione Booking è trattata come “prenotazione confermata, pagamento da ricevere in loco”.

Schema di base nel database
Tabella suggerita
Se vuoi separare bene le sorgenti:



sql
CREATE TABLE bookings_booking (
    id INT AUTO_INCREMENT PRIMARY KEY,

    -- Riferimento a Booking
    booking_reference VARCHAR(50) NOT NULL,          -- ID prenotazione Booking
    booking_status ENUM('new','modified','cancelled') DEFAULT 'new',

    -- Dati soggiorno
    checkin DATETIME NOT NULL,
    checkout DATETIME NOT NULL,
    adults INT DEFAULT 1,
    children INT DEFAULT 0,

    -- Mappatura interna
    room_type_id INT,                                -- FK verso tua tabella stanze
    table_id INT,                                    -- FK verso tavoli (se applicabile)
    guest_name VARCHAR(150),
    guest_email VARCHAR(150),
    guest_phone VARCHAR(50),

    -- Note e tracciatura
    notes TEXT,
    imported_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    -- Chiave univoca per evitare doppioni
    UNIQUE KEY unique_booking_ref (booking_reference)
);
Se preferisci usare una tabella unica per tutte le prenotazioni, puoi aggiungere solo un campo:

sql
ALTER TABLE prenotazioni
ADD COLUMN source ENUM('site','booking') DEFAULT 'site',
ADD COLUMN booking_reference VARCHAR(50) NULL DEFAULT NULL;
Flusso di integrazione
Abilitazione API Reservations

Il cliente deve:

Avere un account Booking Extranet attivo.

Registrare il tuo sistema come provider di connettività / channel manager.

Booking ti fornisce:

URL di base (https://secure-supply-xml.booking.com/hotels/xml/reservations),

credenziali (username/password o token) per l’accesso.

Cron job / job periodico

Implementa un cron job (es. ogni 20–30secondi) sul tuo server che:

Chiama POST /hotels/xml/reservations.

Recupera le prenotazioni nuove/modificate/cancellate.

Parsing dell’XML/B.XML (es. B.Create, B.Modify, B.Cancel).

Mappa i campi:

reservation id, dates, room type, guest, ecc.

Inserisce o aggiorna la riga in bookings_booking o nella tabella principale prenotazioni.

Visualizzazione nell’admin

Nella pagina admin delle prenotazioni:

Aggiungi un filtro: “Origine: Tutte / Sito / Booking.com”.

Mostra le prenotazioni Booking con un badge/etichetta diversa.

Per il cliente:

Non permettere la cancellazione diretta da qui se non vuoi replicare le annullazioni su Booking.

Le eventuali cancellazioni possono essere gestite da Booking Extranet o da un channel manager esterno.

Considerazioni pratiche importanti
Booking richiede che il tuo sistema sia “provider di connettività” (o che tu usi un channel manager che fa da intermediario).

Non devi/duplicare il pagamento:

Booking gestisce il pagamento online se il canale lo prevede,

il tuo sistema tratta le prenotazioni Booking come prenotate, pagamento in loco.

Se non vuoi gestire direttamente l’XML/B.XML, puoi:

usare un channel manager (es. Lodgify, mobile‑calendar, ecc.),

sincronizzare il tuo DB con le loro API o file di export.

Passi concreti da fare “domani”
Chiedere al cliente:

credenziali Booking Extranet,

conferma che il suo hotel è già attivo su Booking e che vuole usare Booking come canale aggiuntivo.

Decidere:

se usare una tabella separata per Booking o una colonna source nella tabella principale.

Progettare:

il cron job (PHP, Python, Node, ecc.) che:

chiama l’endpoint XML,

salva le prenotazioni nel DB.

Aggiornare l’admin:

aggiungere la vista “Prenotazioni Booking”,

eventualmente filtro per origine.

Se mi dici:

tecnologia backend (es. PHP, Laravel, Node.js, ecc.),

tipo di DB (MySQL, PostgreSQL, ecc.),

posso scriverti un mini‑esempio di codice (es. script PHP + cron) che puoi copiare e adattare direttamente nel tuo progetto.

