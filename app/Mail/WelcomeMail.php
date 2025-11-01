<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class WelcomeMail extends Mailable
{
    use Queueable;

    public string $user_full_name;

    public string $email;

    public string $login_url;

    public function __construct($user_full_name, $email, $login_url = null)
    {
        $this->user_full_name = $user_full_name;
        $this->email = $email;
        $this->login_url = $login_url ?? config('app.url') . '/login';
    }

    public function build(): WelcomeMail
    {
        return $this->subject('Welcome to Advisors Academy')->view('emails.welcome');
    }
}
