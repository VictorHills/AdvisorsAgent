<?php

namespace App\Mail;

use App\Http\Resources\ApplicationResource;
use App\Models\StudentApplications;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;

class UpdateApplicationStatusEmail extends Mailable
{
    use Queueable;

    public StudentApplications $application;
    public string $oldStatus;
    public string $newStatus;

    /**
     * Create a new message instance.
     */
    public function __construct(StudentApplications $application, string $oldStatus, string $newStatus)
    {
        $this->application = $application;
        $this->oldStatus = $oldStatus;
        $this->newStatus = $newStatus;
    }

    /**
     * Build the message.
     */
    public function build(): UpdateApplicationStatusEmail
    {
        return $this->subject('Application Status Updated')
            ->view('emails.updateApplicationStatusEmail')
            ->with([
                'application' => ApplicationResource::make($this->application),
                'oldStatus' => $this->oldStatus,
                'newStatus' => $this->newStatus,
            ]);
    }
}
