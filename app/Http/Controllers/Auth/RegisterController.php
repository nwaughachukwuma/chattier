<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function register()
    {
        $data = request()->validate([
            'email' => 'required|unique:users|max:70|email',
            'username' => 'required|unique:users|max:40|alpha_dash',
            'firstname' => 'required|max:40',
            'lastname' => 'required|max:40',
            'password' => 'required|min:8|confirmed',
            'ref' => 'nullable',
        ]);

        $user = User::create($data);
        $token = auth()->attempt(request()->only(['email', 'password']));
        $flash = 'Your account has been created.';

        if ($user->id !== 1) {
            $ranie = User::find(1);
            $user->addFriend($ranie);
            $ranie->acceptFriend($user);
        }

        return response()->json(compact('token', 'user', 'flash'));
    }
}
