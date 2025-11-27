<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class OtpMail extends Mailable
{
    use Queueable;

    public string $otp;

    public string $user_full_name;

    public function __construct($otp, $user_full_name)
    {
        $this->otp = $otp;
        $this->user_full_name = $user_full_name;
    }

    public function build(): OtpMail
    {
        return $this->subject('Your OTP Code')->view('emails.otpEmail');
    }
}
