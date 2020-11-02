<?php

namespace App\Mail;

use App\Notification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RequestStatusEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = 'Work-From-Home Request Status Change';
    protected $notification;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Notification $notification)
    {
        $this->notification = $notification;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->subject = 'Work-From-Home Request Status Change';
        return $this->view('emails.status_change')
            ->with([
                'status' => $this->notification->status,
                'content' => $this->notification->content
            ]);
    }
}
