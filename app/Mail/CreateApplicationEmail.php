<?php

namespace App\Mail;

use App\Http\Resources\ApplicationResource;
use App\Models\StudentApplications;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;

class CreateApplicationEmail extends Mailable
{
    use Queueable;

    public StudentApplications $application;

    /**
     * Create a new message instance.
     */
    public function __construct(StudentApplications $studentApplications)
    {
        $this->application = $studentApplications;
    }

    /**
     * Build the message.
     */
    public function build(): CreateApplicationEmail
    {
        return $this->subject('New Application Submitted')
            ->view('emails.createApplicationEmail')
            ->with([
                'application' => ApplicationResource::make($this->application),
            ]);
    }
}

