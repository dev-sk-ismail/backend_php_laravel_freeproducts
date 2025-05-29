<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class sendMailtoUser extends Mailable
{
    use Queueable, SerializesModels;
     public $userData;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($userData)
    {
        $this->userData = $userData;
        //dd($this->userData);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

       return $this -> subject('New Amazon Bottle Request From')
            ->view('user.email-template',[
                'userData' => $this->userData
            ]);;
       
    }
}
