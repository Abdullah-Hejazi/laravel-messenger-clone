<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use App\Models\Message;
use Illuminate\Http\Request;

class FriendController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        $friends = Friend::with('friend')->where('user_id', auth()->user()->id)->get();
        
        foreach($friends as $friend) {
            $message = Message::where(function($q) use ($friend) {
                $q->where(function($query) use ($friend){
                        $query->where('sender_id', $friend->friend->id)
                              ->where('reciever_id', auth()->user()->id);
                    })
                  ->orWhere(function($query) use ($friend) {
                        $query->where('sender_id', auth()->user()->id)
                              ->where('reciever_id', $friend->friend->id);
                    });
            })->latest('created_at')->first();

            $friend->last_message = $message;
            $friend->unread_count =  Message::where('sender_id', $friend->friend->id)->where('reciever_id', auth()->user()->id)->where('read', false)->count();
        }


        return response()->json($friends);
    }
}
