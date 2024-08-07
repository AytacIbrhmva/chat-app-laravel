<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function sendMessage(Request $request)
    {

        $username = $request->input('username');
        $message = $request->input('message');
        $members = $request->input('members');

        event(new MessageSent($message, $username, $members));

        return response()->json(['status' => 'Message Sent!']);
    }
}
