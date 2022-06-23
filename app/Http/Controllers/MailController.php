<?php

namespace App\Http\Controllers;

use App\Mail\OrderMail;
use App\Models\HoaDon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function sendMail(Request $request)
    {
        // $user = Auth::user();
        // $data = $request->all();
        // $data['email'] = $request->email;
        // $hoadon = HoaDon::whereId(4)->first();

        // $mailable = new OrderMail($user, $hoadon);
        // Mail::to('tamdz515@gmail.com')->queue($mailable);

        // return true;
    }
}
