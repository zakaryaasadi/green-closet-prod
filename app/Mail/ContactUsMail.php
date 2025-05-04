<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactUsMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $name;

    public string $email;

    public string $phone;

    public string $details;

    public string $kiswaEmail;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name,
                                $email,
                                $phone,
                                $details,
                                $kiswaEmail)
    {
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->details = $details != null ? $details : '';
        $this->kiswaEmail = $kiswaEmail;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('New Website Contact Form')
            ->view('emails.contact')
            ->replyTo($this->email)
            ->to($this->kiswaEmail);
    }
}
