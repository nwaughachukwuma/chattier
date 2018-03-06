<?php

Route::get('/{vue_capture?}', function () {
    $config = json_encode([
        'app' => collect(config('app'))
            ->only(['name', 'env', 'timezone'])
            ->merge(['url' => url('/')]),
    ]);

    return view('home')->with(compact('config'));
})->where('vue_capture', '[\/\w\.-]*');
