<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\MessageReceived;

class MessageController extends Controller
{
    public function store(Request $request)
    {
        $message = $request->message;
        $id = 1;
        
        event(new MessageReceived($message));
        
        return response($message, 201);
    }
}
