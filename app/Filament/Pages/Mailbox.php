<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Webklex\IMAP\Facades\Client;
use Illuminate\Support\Facades\Mail;
use Filament\Notifications\Notification;
use Livewire\WithFileUploads;
use Carbon\Carbon;

class Mailbox extends Page
{
    use WithFileUploads;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';
    protected static ?string $navigationLabel = 'Email';
    protected static ?string $navigationGroup = 'Amministrazione';
    protected static ?int $navigationSort = 2;
    protected static string $view = 'filament.pages.mailbox';

    // Paginazione
    public $emails = [];
    public $currentPage = 1;
    public $perPage = 10;
    public $totalEmails = 0;
    
    // Gestione Messaggio (Lettura/Invio)
    public $selectedEmail = null;
    public $toEmail = "";       // Per nuove email
    public $subject = "";       // Per nuove email
    public $replyBody = "";
    public $attachments = []; 

    public function mount()
    {
        $this->loadEmails();
    }

    /**
     * Sincronizza la lista email (Ordine Decrescente)
     */
    public function loadEmails()
    {
        try {
            $client = Client::account('default');
            $client->connect();
            $folder = $client->getFolder('INBOX');
            
            $this->totalEmails = $folder->query()->all()->count();

            $messages = $folder->query()
                ->all()
                ->setFetchOrderDesc() 
                ->limit($this->perPage, ($this->currentPage - 1) * $this->perPage)
                ->get();

            $items = [];
            foreach ($messages as $message) {
                $date = $message->getDate()->first();
                $from = $message->getFrom()->first();
                $flags = $message->getFlags();
                $isUnread = !($flags->has('seen') || $flags->has('Seen'));

                $items[] = [
                    'uid' => $message->getUid(),
                    'subject' => (string) $message->getSubject(),
                    'from' => $from ? $from->mail : 'Sconosciuto',
                    'date' => $date ? Carbon::parse($date)->format('d/m/Y H:i') : 'n.d.',
                    'is_unread' => $isUnread,
                ];
            }

            $this->emails = array_reverse($items);

        } catch (\Exception $e) {
            \Log::error("Errore Mailbox: " . $e->getMessage());
            $this->emails = [];
        }
    }

    /**
     * Apre il modal per una NUOVA EMAIL (vuota)
     */
    public function composeEmail()
    {
        $this->reset(['selectedEmail', 'replyBody', 'attachments', 'toEmail', 'subject']);
        $this->dispatch('open-modal', id: 'view-email');
    }

    /**
     * Apre il modal per LEGGERE/RISPONDERE
     */
    public function openEmail($uid)
    {
        try {
            $client = Client::account('default');
            $client->connect();
            $folder = $client->getFolder('INBOX');
            $message = $folder->query()->getMessageByUid($uid);

            $message->setFlag('Seen');

            $rawBody = $message->hasHTMLBody() ? $message->getHTMLBody() : $message->getTextBody();
            
            $this->selectedEmail = [
                'uid' => $uid,
                'subject' => (string) $message->getSubject(),
                'from' => $message->getFrom()->first()->mail,
                'body' => mb_convert_encoding($rawBody, 'UTF-8', 'UTF-8'),
            ];

            $this->loadEmails();
            $this->dispatch('open-modal', id: 'view-email');
        } catch (\Exception $e) {
            \Log::error("Errore apertura mail: " . $e->getMessage());
            Notification::make()->title('Errore apertura')->danger()->send();
        }
    }

    /**
     * Invia il messaggio (Nuovo o Risposta)
     */
    public function sendReply()
    {
        // Validazione dinamica
        $this->validate([
            'toEmail' => $this->selectedEmail ? 'nullable' : 'required|email',
            'replyBody' => 'required',
            'attachments.*' => 'max:51200', 
        ]);

        try {
            // Se selectedEmail esiste è una risposta, altrimenti è una nuova mail
            $destinatario = $this->selectedEmail ? $this->selectedEmail['from'] : $this->toEmail;
            $oggetto = $this->selectedEmail ? "Re: " . $this->selectedEmail['subject'] : ($this->subject ?: "Nuovo Messaggio da Ca' Scirocco");
            
            $filePaths = [];
            foreach ($this->attachments as $attachment) {
                $filePaths[] = [
                    'path' => $attachment->getRealPath(),
                    'name' => $attachment->getClientOriginalName(),
                    'mime' => $attachment->getMimeType(),
                ];
            }

            Mail::raw($this->replyBody, function ($message) use ($destinatario, $oggetto, $filePaths) {
                $message->to($destinatario)->subject($oggetto);
                
                foreach ($filePaths as $file) {
                    $message->attach($file['path'], [
                        'as' => $file['name'],
                        'mime' => $file['mime'],
                    ]);
                }
            });

            $this->reset(['replyBody', 'attachments', 'selectedEmail', 'toEmail', 'subject']);
            $this->dispatch('close-modal', id: 'view-email');
            Notification::make()->title('Email inviata con successo!')->success()->send();
            
        } catch (\Exception $e) {
            \Log::error("Errore Invio: " . $e->getMessage());
            Notification::make()->title('Errore invio: ' . $e->getMessage())->danger()->send();
        }
    }

    public function deleteEmail($uid)
    {
        try {
            $client = Client::account('default');
            $client->connect();
            $folder = $client->getFolder('INBOX');
            $folder->query()->getMessageByUid($uid)->delete();
            $this->loadEmails();
            Notification::make()->title('Messaggio eliminato')->success()->send();
        } catch (\Exception $e) {
            Notification::make()->title('Errore eliminazione')->danger()->send();
        }
    }

    public function nextPage() { $this->currentPage++; $this->loadEmails(); }
    public function prevPage() { if ($this->currentPage > 1) { $this->currentPage--; $this->loadEmails(); } }
}
