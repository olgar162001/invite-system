<?php

namespace App\Mail;

namespace App\Mail;

use App\Models\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $customer;
    public $password;

    public function __construct(Customer $customer, $password)
    {
        $this->customer = $customer;
        $this->password = $password;
    }

    public function build()
    {
        return $this->subject('Welcome to the Invitation System')
                    ->view('emails.welcome')
                    ->with([
                        'name' => $this->customer->name,
                        'email' => $this->customer->email,
                        'password' => $this->password,
                        'loginUrl' => url('/login'),
                    ]);
    }
}
