<?php

namespace App\Jobs;

use App\Mail\OrderMail;
use App\Models\ChiTietHoaDon;
use App\Models\HoaDon;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $user;
    protected $hoadon;
    protected $data;
    protected $infoPayMent;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, HoaDon $hoadon, $data, $infoPayMent)
    {
        $this->user = $user;
        $this->hoadon = $hoadon;
        $this->data = $data;
        $this->infoPayMent = $infoPayMent;
    }


    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = $this->data;
        $infoPayMent = $this->infoPayMent;
        $mail = new OrderMail($this->user, $this->hoadon, $data, $infoPayMent);
        Mail::to($this->hoadon->email)->send($mail);
    }
}
