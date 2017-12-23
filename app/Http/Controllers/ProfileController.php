<?php

namespace App\Http\Controllers;

use App\User;

class ProfileController extends Controller
{
    public function show($username)
    {
        $user = User::where('username', $username)->firstOrFail();

        return response()->json(compact('user'));
    }
}
