<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendEmployeeMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct($name, $email, $password)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    public function build()
    {
        return $this->subject('Votre compte a été créé')
                   ->view('emails.credentials_employee') 
                   ->with([
                       'name' => $this->name,
                       'email' => $this->email,
                       'password' => $this->password,
                   ]);
    }
}
