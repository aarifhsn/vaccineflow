<?php

namespace App\Mail;

use App\Enums\UserStatus;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VaccinationScheduled extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $user;

    public function __construct(User $user)
    {
        if (! $user) {
            throw new \InvalidArgumentException('User cannot be null.');
        }
        $this->user = $user;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Vaccination Scheduled',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(view: 'emails.vaccination-scheduled');
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->view('emails.vaccination-scheduled')
            ->subject('Vaccination Schedule Confirmation')
            ->with([
                'name' => $this->user->name,
                'center' => $this->user->vaccineCenter->name,
                'date' => $this->user->scheduled_date
                    ? $this->user->scheduled_date->format('Y-m-d')
                    : UserStatus::NOT_SCHEDULED,
            ]);
    }
}
