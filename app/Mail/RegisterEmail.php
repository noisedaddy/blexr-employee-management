<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RegisterEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = 'Your registration link:';
    protected $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->subject = 'Activation Link';
        return $this->view('emails.registration')
            ->with([
                'link' => env('APP_URL') ? env('APP_URL').'/register/'.$this->user->confirmation_token : 'http://localhost/ship-management/public/register/'.$this->user->confirmation_token
            ]);
    }
}
