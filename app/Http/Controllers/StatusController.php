<?php

namespace App\Http\Controllers;

use App\Status;

class StatusController extends Controller
{
    protected function validateStatus($messages = [], $customAttributes = [])
    {
        return request()->validate(['body' => 'required|max:300'], $messages, $customAttributes);
    }

    public function index()
    {
        $cursor = (request()->has('cursor') ? ['id' => request('cursor')] : []);

        $ids = auth()->user()->friends()->pluck('id')->push(auth()->id());

        $statuses = Status::topLevel()
            ->whereIn('user_id', $ids)
            ->cursorPaginate(5, $cursor, 'desc');

        return response()->json($statuses);
    }

    public function store()
    {
        $data = $this->validateStatus([], ['body' => 'status']);

        $status = auth()->user()->statuses()->create($data)->load('user');

        $flash = 'Status posted.';

        return response()->json(compact('status', 'flash'));
    }

    public function show(Status $status)
    {
        //
    }

    public function destroy(Status $status)
    {
        if ($status->user->id !== auth()->id()) {
            return response()->json(['flash' => 'Invalid operation.'], 401);
        }

        $status->delete();

        return response()->json(['flash' => 'Status deleted.']);
    }

    public function storeReply(Status $status)
    {
        $data = $this->validateStatus([], ['body' => 'reply']);

        $data['user_id'] = auth()->id();

        if (!in_array(auth()->user()->checkFriendship($status->user), ['friends', 'same_user'])) {
            return response()->json([
                'flash' => "Add {$status->user->firstname} as a friend to reply to their statuses."
            ], 422);
        }

        $reply = $status->replies()->create($data)->load('user');

        $flash = 'Reply posted.';

        return response()->json(compact('reply', 'flash'));
    }
}
