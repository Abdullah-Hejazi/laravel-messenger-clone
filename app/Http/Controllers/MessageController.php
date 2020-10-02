<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use App\Events\MessangerEvent;

class MessageController extends Controller {
    public function __construct() {
        $this->middleware('auth');
    }

    public function index($id) {
        $messages = Message::where(function($q) use ($id) {
            $q->where(function($query) use ($id){
                    $query->where('sender_id', $id)
                          ->where('reciever_id', auth()->user()->id);
                })
              ->orWhere(function($query) use ($id) {
                    $query->where('sender_id', auth()->user()->id)
                          ->where('reciever_id', $id);
                });
        })->get();
        
        Message::where('sender_id', $id)->where('reciever_id', auth()->user()->id)->where('read', false)->update([
            'read'  =>  true
        ]);

        return response()->json($messages);
    }

    public function send(Request $request, $id) {
        $message = Message::create([
            'sender_id'     =>      auth()->user()->id,
            'reciever_id'   =>      $id,
            'text'          =>      $request->text
        ]);

        broadcast(new MessangerEvent('message', $message, $message->reciever_id));

        return response()->json($message);
    }

    public function read($id) {
        $message = Message::where('id', $id)->update([
            'read'      =>      true
        ]);

        return "";
    }
}
