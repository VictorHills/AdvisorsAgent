<?php

namespace App\Http\Controllers;

use App\Mail\OtpMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{

    public function getUser($email)
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            return null;
        }

        return [
            'email' => $user->email,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'full_name' => $user->first_name . ' ' . $user->last_name,
            'agency_name' => $user->agency_name,
            'business_registration_number' => $user->business_registration_number,
            'role_name' => $user->role_name,
            'is_terms_and_condition_accepted' => $user->is_terms_and_condition_accepted,
        ];
    }

    public function WelcomeEmail()
    {

    }

    public function OtpEmail($email, $otp)
    {
        $user = $this->getUser($email);

        if (!$user) {
            return;
        }

        Mail::to($user['email'])->send(new OtpMail($otp, $user['full_name']));
    }

    public function ApplicationStatusEmail()
    {

    }

    public function ApplicationCreateEmail()
    {

    }
}
