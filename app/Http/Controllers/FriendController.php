<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use Illuminate\Http\Request;

class FriendController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        return response()->json(Friend::with('friend')->where('user_id', auth()->user()->id)->get());
    }
}
