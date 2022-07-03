<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class VeryEmail extends Mailable
{
    use Queueable, SerializesModels;
    private $user;
    private $hash;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $hash)
    {
        $this->user = $user;
        $this->hash = $hash;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $message = 'Xác nhận địa chỉ email';
        return $this->subject($message)->markdown('emails.verify-email')->with('user', $this->user)->with('hash', $this->hash);
   
    }
}
