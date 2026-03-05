<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Bus\Queueable;

class AgreementSigningMail extends Mailable
{
    use Queueable;

    public string $user_full_name;
    public string $email;
    public string $signing_url;

    public function __construct($user_full_name, $email)
    {
        $this->user_full_name = $user_full_name;
        $this->email = $email;
        $this->signing_url = config('app.agreement_signing_url');
    }

    public function build(): AgreementSigningMail
    {
        return $this->subject('Agreement Signing Required - Advisors Academy')->view('emails.agreementSigning');
    }
}
