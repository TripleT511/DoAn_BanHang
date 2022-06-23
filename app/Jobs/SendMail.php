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

    /**
     * Create a new job instance.
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
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = $this->data;
        $mail = new OrderMail($this->user, $this->hoadon, $data);
        Mail::to('tamdz515@gmail.com')->send($mail);
    }
}
