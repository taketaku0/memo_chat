<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Events\MessageReceived;
use Illuminate\Support\Facades\Redirect;

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
        
        if($request->joinFlag)
            return Redirect::route('group.join', $request->group_id);
        else
            return response($messageData, 201);
    }
}
