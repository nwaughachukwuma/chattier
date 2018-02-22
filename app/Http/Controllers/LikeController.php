<?php

namespace App\Http\Controllers;

use App\Status;

class LikeController extends Controller
{
    public function store(Status $status)
    {
        if (!$status->of_friend || $status->liked) {
            return response()->json(['flash' => 'Invalid operation.'], 422);
        }

        auth()->user()->like($status);

        return response()->json('liked', 201);
    }

    public function destroy(Status $status)
    {
        auth()->user()->unlike($status);

        return response()->json('unliked', 200);
    }
}
