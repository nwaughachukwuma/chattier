<?php

namespace App\Http\Controllers;

use App\User;

class SearchController extends Controller
{
    public function results()
    {
        $keyword = request('keyword');

        if (!$keyword) {
            return response()->json(['message' => 'Search keyword not provided.'], 422);
        }

        $query = User::where('username', 'LIKE', "%{$keyword}%")
            ->orWhereRaw('CONCAT(firstname, " ", lastname) LIKE ?', ["%{$keyword}%"]);

        if (request()->has('limit')) {
            $query = $query->limit(request('limit'));
        }

        return response()->json($query->get());
    }
}
