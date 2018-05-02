<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

class TokenController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->only('refresh');
        $this->middleware('jwt.auth')->only('user');
    }

    public function refresh()
    {
        return response()->json(['token' => auth()->refresh()]);
    }

    public function user()
    {
        return auth()->user();
    }
}
