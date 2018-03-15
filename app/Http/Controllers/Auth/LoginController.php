<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    private $token;

    public function __construct()
    {
        $this->middleware('guest:api')->only('login', 'refresh');
        $this->middleware('jwt.auth:api')->only('logout');
    }

    protected function attemptLogin(Request $request)
    {
        $this->token = $this->guard()->attempt($this->credentials($request));
        return (bool) $this->token;
    }

    protected function guard()
    {
        return auth()->guard('api');
    }

    protected function sendLoginResponse(Request $request)
    {
        return response()->json([
            'token' => $this->token,
            'user' => $this->guard()->user(),
            'flash' => 'You are now signed in.',
        ]);
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        return response()->json(['flash' => trans('auth.failed')], 422);
    }

    public function refresh()
    {
        return response()->json(['token' => $this->guard()->refresh()]);
    }

    public function logout()
    {
        $this->guard()->logout();
        return response()->json(['flash' => 'You have been signed out.']);
    }
}
