<?php

namespace App\Http\Controllers;

use App\Models\FriendRequest;
use App\Models\User;
use App\Models\Friend;
use Illuminate\Http\Request;
use App\Events\MessangerEvent;

class FriendRequestController extends Controller {
    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        $sent = FriendRequest::with('friend')->where('user_id', auth()->user()->id)->where('accepted', false)->get();
        $recieved = FriendRequest::with('user')->where('friend_id', auth()->user()->id)->where('accepted', false)->get();

        return response()->json([
            'sent'      =>      $sent,
            'recieved'  =>      $recieved
        ]);
    }

    public function add(Request $request) {
        $request->validate([
            'email'     =>      'required|email'
        ]);

        $friend = User::where('email', $request->email)->first();

        if(!$friend) {
            return response()->json([
                'message'       =>      'This user doesn\'t exist !'
            ], 404);
        }

        if (auth()->user()->isFriendsWith($friend->id)) {
            return response()->json([
                'message'       =>      'This user is already in your friend list !'
            ], 403);
        }
        
        if (FriendRequest::where('user_id', auth()->user()->id)->where('friend_id', $friend->id)->first()) {
            return response()->json([
                'message'       =>      'You already sent a friend request to this user !'
            ], 403);
        }
        
        if (FriendRequest::where('user_id', $friend->id)->where('friend_id', auth()->user()->id)->first()) {
            return response()->json([
                'message'       =>      'This user has already sent you a friend request !'
            ], 403);
        }

        $friend_request = FriendRequest::create([
            'user_id'       =>      auth()->user()->id,
            'friend_id'     =>      $friend->id
        ]);

        $friend_request2 = FriendRequest::with('user')->where('id', $friend_request->id)->first();
        
        broadcast(new MessangerEvent('friend_request_recieved', $friend_request2, $friend->id));

        return response()->json($friend_request2);
    }

    public function accept($id) {
        $request = FriendRequest::where('id', $id)->first();

        if(!$request) {
            return response()->json([
                'message'       =>      'This request doesn\'t exist !'
            ], 404);
        }

        if ($request->friend_id != auth()->user()->id) {
            return response()->json([
                'message'       =>      'You are not allowed to respond to this request'
            ], 403);
        }
        
        if (auth()->user()->isFriendsWith($request->user_id)) {
            $request->delete();

            return response()->json([
                'message'       =>      'You are already a friend !'
            ], 403);
        }

        $f = Friend::create([
            'user_id'   =>  auth()->user()->id,
            'friend_id' =>  $request->user_id
        ]);

        $friend = Friend::with('friend')->where('id', $f->id)->first();

        Friend::create([
            'user_id'   =>  $request->user_id,
            'friend_id' =>  auth()->user()->id
        ]);
        
        broadcast(new MessangerEvent('friend_request_accepted', $friend, $request->user_id));

        $request->delete();

        return response()->json('Success');
    }

    public function reject($id) {
        $request = FriendRequest::where('id', $id)->first();

        if(!$request) {
            return response()->json([
                'message'       =>      'This request doesn\'t exist !'
            ], 404);
        }

        if ($request->friend_id != auth()->user()->id) {
            return response()->json([
                'message'       =>      'You are not allowed to respond to this request'
            ], 403);
        }
        
        if (auth()->user()->isFriendsWith($request->user_id)) {
            $request->delete();

            return response()->json([
                'message'       =>      'You are already a friend !'
            ], 403);
        }
        
        broadcast(new MessangerEvent('friend_request_rejected', '', $request->user_id));
    
        $request->delete();

        return response()->json('Success');
    }

    public function cancel($id) {
        $request = FriendRequest::where('id', $id)->first();

        if(!$request) {
            return response()->json([
                'message'       =>      'This request doesn\'t exist !'
            ], 404);
        }

        if ($request->user_id != auth()->user()->id) {
            return response()->json([
                'message'       =>      'You are not allowed to cancel this request'
            ], 403);
        }
        
        if (auth()->user()->isFriendsWith($request->user_id)) {
            $request->delete();

            return response()->json([
                'message'       =>      'You are already a friend !'
            ], 403);
        }

        $request->delete();

        return response()->json('Success');
    }
}
