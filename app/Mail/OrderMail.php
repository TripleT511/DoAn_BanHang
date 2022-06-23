<?php

namespace App\Mail;

use App\Models\ChiTietHoaDon;
use App\Models\HoaDon;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderMail extends Mailable
{
    use Queueable, SerializesModels;
    private $user;
    private $hoadon;
    private $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, HoaDon $hoadon, $data)
    {
        $this->user = $user;
        $this->hoadon = $hoadon;
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $message = 'Triple T Shop đã nhận đơn hàng #' . $this->hoadon->id;
        return $this->subject($message)->markdown('emails.orders')->with('user', $this->user)->with('hoadon', $this->hoadon)->with('data', $this->data);
    }
}
