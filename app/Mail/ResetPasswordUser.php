<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordUser extends Mailable
{
    use Queueable, SerializesModels;
    private $user;
    private $token;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $token)
    {
        $this->user = $user;
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $message = 'Đặt lại mật khẩu';
        return $this->subject($message)->markdown('emails.user-reset')->with('user', $this->user)->with('token', $this->token);
    }
}
