<?php

namespace App\Http\Controllers;

use App\Status;

class ReplyController extends Controller
{
    public function index(Status $status)
    {
        return response()->json($status->replies);
    }

    public function store(Status $status)
    {
        $data = request()->validate(['body' => 'required|max:300'], [], ['body' => 'reply']);

        $data['user_id'] = auth()->id();

        if (!$status->of_friend && $status->user->id !== auth()->id()) {
            return response()->json([
                'flash' => "Add {$status->user->firstname} as a friend to reply to their statuses."
            ], 422);
        }

        $reply = $status->replies()->create($data)->load('user');

        $flash = 'Reply posted.';

        return response()->json(compact('reply', 'flash'));
    }
}
