<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BackupCleanFailMail extends Mailable
{
    use Queueable, SerializesModels;

    protected array $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('Backup Clean fail')
            ->view('emails.backup-clean-fail')
            ->with('data', $this->data);
    }
}
