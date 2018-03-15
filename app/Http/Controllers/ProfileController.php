<?php

namespace App\Http\Controllers;

use App\User;

class ProfileController extends Controller
{
    public function show($username)
    {
        $user = User::where('username', $username)->firstOrFail();

        $friends = $user->friends();

        $friends_total = $friends->count();

        if ($friends_total > 6) {
            $friends = $friends->random(7)->shuffle();
        }

        $friendship = (auth()->check() ? auth()->user()->checkFriendship($user) : 'unauthenticated');

        return response()->json(compact('user', 'friends', 'friends_total', 'friendship'));
    }

    public function update()
    {
        $data = request()->validate([
            'firstname' => 'required|max:40',
            'lastname'  => 'required|max:40',
            'location'  => 'max:20',
        ]);

        auth()->user()->update($data);

        return response()->json(['flash' => 'Your profile has been updated.']);
    }

    public function statuses(User $user)
    {
        $cursor = (request()->has('cursor') ? ['id' => request('cursor')] : []);

        $statuses = $user->statuses()->topLevel()
            ->cursorPaginate(5, $cursor, 'desc');

        return response()->json($statuses);
    }
}
