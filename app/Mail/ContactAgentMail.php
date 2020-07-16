<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactAgentMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $email;
    public $message;
    public $name;
    public $visitor;
    public $phone;
    public $user_name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $name)
    {

        $this->email = $data['email'];
        $this->message = $data['message'];
        $this->visitor = $data['i_am'];
        $this->phone = $data['phone'];
        $this->user_name = $data['name'];
        $this->name = $name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('website.emails.agency.contact');
    }
}
