<?php

namespace App\Http\Controllers;

use App\User;

class FriendshipController extends Controller
{
    public function index()
    {
        return response()->json([
            'friends' => auth()->user()->friends(),
            'requests' => auth()->user()->friendRequestsReceived(),
        ]);
    }

    public function store()
    {
        $user = User::findOrFail(request('id'));

        if (auth()->user()->checkFriendship($user) !== 'not_friends') {
            return response()->json(['flash' => 'Invalid operation.'], 422);
        }

        auth()->user()->addFriend($user);
        return response()->json(['flash' => 'Friend request sent.']);
    }

    public function update(User $user)
    {
        if (auth()->user()->checkFriendship($user) !== 'pending') {
            return response()->json(['flash' => 'Invalid operation.'], 422);
        }

        auth()->user()->acceptFriend($user);
        return response()->json(['flash' => "{$user->firstname} is now your friend."]);
    }

    public function destroy(User $user)
    {
        auth()->user()->deleteFriend($user);

        $messages = [
            'cancel' => 'Friend request cancelled.',
            'decline' => 'Friend request declined.',
            'unfriend' => "You have unfriended {$user->firstname}.",
        ];

        return response()->json(['flash' => $messages[request('action')]]);
    }
}
