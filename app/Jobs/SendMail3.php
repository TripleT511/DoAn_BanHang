<?php

namespace App\Jobs;

use App\Mail\OrderCancel;
use App\Models\HoaDon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendMail3 implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $hoadon;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(HoaDon $hoaDon)
    {
        $this->hoadon = $hoaDon;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $mail = new OrderCancel($this->hoadon);
        Mail::to($this->hoadon->email)->send($mail);
    }
}
