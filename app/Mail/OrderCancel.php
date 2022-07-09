<?php

namespace App\Mail;

use App\Models\HoaDon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderCancel extends Mailable
{
    use Queueable, SerializesModels;
    private $hoadon;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(HoaDon $hoaDon)
    {
        $this->hoadon = $hoaDon;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $message = 'Đơn hàng #'
            . $this->hoadon->id . ' không thể thực hiện được';
        return $this->subject($message)->markdown('emails.order-cancel')->with('hoadon', $this->hoadon);
    }
}
