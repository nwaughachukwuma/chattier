<?php

namespace App\Http\Controllers;

class FriendController extends Controller
{
    public function index()
    {
        $friends = auth()->user()->friends();
        $requests = auth()->user()->friendRequestsReceived();

        return response()->json(compact('friends', 'requests'));
    }
}
