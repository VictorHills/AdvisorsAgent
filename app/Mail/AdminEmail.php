<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;

class AdminEmail extends Mailable
{
    use Queueable;

    public User $user;

    /**
     * Create a new message instance.
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     */
    public function build(): AdminEmail
    {
        return $this->subject('New User Registration Notification')
            ->view('emails.adminEmail')
            ->with([
                'user' => $this->user,
            ]);
    }
}
