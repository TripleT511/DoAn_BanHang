<?php

namespace App\Jobs;

use App\Mail\VeryEmail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendMail2 implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $user;
    protected $hash;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, $hash)
    {
        $this->user = $user;
        $this->hash = $hash;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $mail = new VeryEmail($this->user, $this->hash);
        Mail::to('nguyenslimz@gmail.com')->send($mail);
    }
}
