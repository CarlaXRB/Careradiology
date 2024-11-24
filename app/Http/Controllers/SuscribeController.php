<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;

class SuscribeController extends Controller
{
    public function mailMe()
    {
        Mail::to('carlaximenarb@gmail.com')->send(new WelcomeMail());
        return view('welcome');
    }
}
