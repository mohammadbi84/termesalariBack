<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyEmail;

class MailController extends Controller
{
    public function verifyEmail(Request $request)
    {
    	$data = [
			'title' => 'Test Email',
			'body' => 'Test sending email by laravel'
		];
    	Mail::to('lms_fezeledu@yahoo.com')
		->send(new VerifyEmail($data));
    }
}
