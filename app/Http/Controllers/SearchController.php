<?php

namespace App\Http\Controllers;

use App\User;
use DB;

class SearchController extends Controller
{
    public function results()
    {
        $keyword = request('keyword');

        if (!$keyword) {
            return response()->json(['message' => 'Search keyword not provided.'], 422);
        }

        $users = User::where(DB::raw("CONCAT(firstname, ' ', lastname)"), 'LIKE', "%{$keyword}%")
            ->orWhere('username', 'LIKE', "%{$keyword}%")
            ->get();

        return response()->json(compact('users'));
    }
}
