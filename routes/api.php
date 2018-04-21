<?php

Route::namespace('Auth')->group(function () {
    Route::post('/login', 'LoginController@login');

    Route::post('/logout', 'LoginController@logout');

    Route::post('/password/email', 'ForgotPasswordController@sendResetLinkEmail');

    Route::post('/password/reset', 'ResetPasswordController@reset');

    Route::get('/refresh', 'TokenController@refresh');

    Route::post('/register', 'RegisterController@register');

    Route::get('/user', 'TokenController@user');

    Route::post('/password/change', 'ChangePasswordController@change');
});

Route::middleware('jwt.custom.check')->group(function () {
    Route::get('/profile/{username}', 'ProfileController@show');

    Route::get('/profile/{user}/statuses', 'ProfileController@statuses');

    Route::get('/statuses/{status}/replies', 'ReplyController@index');
});

Route::middleware('jwt.auth')->group(function () {
    Route::put('/profile', 'ProfileController@update');

    Route::get('/search', 'SearchController@results');

    Route::resource('/friendships', 'FriendshipController', [
        'only' => ['index', 'store', 'update', 'destroy'],
        'parameters' => ['friendships' => 'user'],
    ]);

    Route::resource('/statuses', 'StatusController', [
        'only' => ['index', 'store', 'destroy'],
    ]);

    Route::post('/statuses/{status}/replies', 'ReplyController@store');

    Route::post('/statuses/{status}/likes', 'LikeController@store');

    Route::delete('/statuses/{status}/likes', 'LikeController@destroy');
});
