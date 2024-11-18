<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Log;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Support\Facades\Storage;
use Illuminate\Mail\Mailables\Attachment;
use Stevebauman\Location\Facades\Location;
use App\Models\Managements\Letters\IncomingLetter;

class IncomingLetterNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $location;
    public $action;
    public $key_id;
    public $oldData;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, $action, $key_id = null, $oldData)
    {
        $this->user = $user;
        $this->action = $action;
        $this->key_id = $key_id;
        $this->oldData = $oldData;
        $this->location = Location::get(request()->ip());
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Aktivitas ' . $this->action . ' Surat Masuk',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        // $oldData = $this->oldData;
        $letter = IncomingLetter::findOrFail($this->key_id);
        // $oldData = $letter->getOriginal();

        return new Content(
            view: 'emails.incoming_letter_notification',
            with: [
                'action' => $this->action,
                'letter' => $letter,
                'oldData' => $this->oldData,
                'location' => $this->location,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $letter = IncomingLetter::find($this->key_id);
        $attachments = [];

        foreach ($letter->file_path as $filePath) {
            $fullPath = storage_path('app/public/' . $filePath);
            if (file_exists($fullPath)) {
                Log::info("File exists: {$fullPath}");
                $attachments[] = Attachment::fromPath($fullPath);
            } else {
                Log::warning("File does not exist: {$fullPath}");
            }
        }

        Log::info('Attachments:', $attachments);

        return $attachments;
    }
}
