<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class EmailController extends Controller
{
    public function send(Request $request)
    {
        Mail::raw('Текст письма', function($message)
        {
            $message->from('us@example.com', 'Laravel');

            $message->to('7eb0467f6d-b0ac85@inbox.mailtrap.io')->cc('bar@example.com');
        });
    }
}
