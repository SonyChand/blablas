<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Log;
use App\Models\Letters\OutgoingLetter;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Support\Facades\Storage;
use Illuminate\Mail\Mailables\Attachment;
use Stevebauman\Location\Facades\Location;

class OutgoingLetterNotification extends Mailable
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
            subject: 'Aktivitas ' . $this->action . ' Surat Keluar',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        // $oldData = $this->oldData;
        $letter = OutgoingLetter::findOrFail($this->key_id);
        $oldData = $letter->getOriginal();

        $letter->letter_destination = json_decode($letter->letter_destination, true);

        $oldData['letter_destination'] = json_decode($oldData['letter_destination'], true);

        return new Content(
            view: 'emails.outgoing_letter_notification',
            with: [
                'action' => $this->action,
                'letter' => $letter,
                'oldData' => $oldData,
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
        $letter = OutgoingLetter::find($this->key_id);
        $attachments = [];
        if ($letter->file_path == null) {
            $filePaths = [
                public_path("storage/surat/surat_keluar/{$letter->letter_type}/{$letter->letter_number}-{$letter->id}.pdf")
            ];
        } else {
            $filePaths = [
                public_path("storage/surat/surat_keluar/{$letter->letter_type}/{$letter->letter_number}-{$letter->id}.pdf")
            ];
        }


        foreach ($filePaths as $filePath) {
            if (file_exists($filePath)) {
                Log::info("File exists: {$filePath}");
                $attachments[] = Attachment::fromPath($filePath);
            } else {
                Log::warning("File does not exist: {$filePath}");
            }
        }

        Log::info('Attachments:', $attachments);

        return $attachments;
    }
}
