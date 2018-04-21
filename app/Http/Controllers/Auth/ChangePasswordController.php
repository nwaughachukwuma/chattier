<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Hash;

class ChangePasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth');
    }

    public function change()
    {
        request()->validate([
            'old_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $response = $this->changePassword(auth()->user(), request('password'));

        return $response == 'passwords.changed'
            ? $this->sendChangeResponse($response)
            : $this->sendChangeFailedResponse($response);
    }

    protected function changePassword($user, $password)
    {
        if (!Hash::check(request('old_password'), $user->password)) {
            return 'auth.failed';
        }

        $user->update(compact('password'));

        return 'passwords.changed';
    }

    protected function sendChangeResponse($response)
    {
        return response()->json(['flash' => trans($response)]);
    }

    protected function sendChangeFailedResponse($response)
    {
        return response()->json([
            'errors' => [
                'old_password' => [trans($response)],
            ],
        ], 422);
    }
}
