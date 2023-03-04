<?php

namespace App\Mail;

use App\Models\JobCancel;
use App\Models\UserJob;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class JobCancelMail extends Mailable
{
    use Queueable, SerializesModels;


    public $user_job;
    public $job_cancel;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(UserJob $user_job, JobCancel $job_cancel)
    {
        $this->user_job = $user_job;
        $this->job_cancel = $job_cancel;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Darba atcelšana',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'emails.cancel',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
