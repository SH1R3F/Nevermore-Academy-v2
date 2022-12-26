<?php

namespace App\Mail;

use Carbon\Carbon;
use App\Models\Assignment;
use App\Models\Submission;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class MonthlyReport extends Mailable
{
    use Queueable, SerializesModels;

    public $report;
    public $name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($notifiable)
    {
        $this->name = $notifiable->name;
        $this->report = [
            'assignments' => Assignment::where('created_at', '>=', Carbon::now()->startOfMonth())->count(),
            'submissions' => Submission::where('created_at', '>=', Carbon::now()->startOfMonth())->count(),
        ];
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Monthly Report',
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
            view: 'mails.monthly-report',
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
