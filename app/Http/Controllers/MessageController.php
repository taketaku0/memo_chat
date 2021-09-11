<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Events\MessageReceived;

class MessageController extends Controller
{
    public function store(Request $request)
    {
        $messageData = new Message;
        $messageData->group_id = $request->group_id;
        $messageData->user_id = $request->user_id;
        $messageData->content = $request->content;
        $messageData->save();
        
        broadcast(new MessageReceived($messageData))->toOthers();
        
        return response($messageData, 201);
    }
}
