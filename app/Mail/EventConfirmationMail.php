<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EventConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $guest;
    public $event;
    public $filePath;

    /**
     * Create a new message instance.
     */
    public function __construct($guest, $event, $filePath)
    {
        $this->guest = $guest;
        $this->event = $event;
        $this->filePath = $filePath;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Event Confirmation for ' . $this->event->event_name)
                    ->view('emails.confirmation')
                    ->attach($this->filePath, [
                        'as' => 'event.ics',
                        'mime' => 'text/calendar',
                    ]);
    }
}
