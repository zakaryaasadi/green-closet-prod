<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReplyContactUsMail extends Mailable
{
    use Queueable, SerializesModels;

    protected String $email;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email)
    {
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Contact request confirmation')
            ->view('emails.contact-reply')
            ->subject('Reply From Kiswa')
            ->replyTo($this->email);
    }
}
