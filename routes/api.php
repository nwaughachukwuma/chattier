<?php

Route::middleware('auth:api')->group(function () {
    Route::get('/user', function () {
        return request()->user();
    });
    Route::get('/check', function () {
        return response(null, 200);
    });
});

Route::namespace('Auth')->group(function () {
    Route::post('/login', 'LoginController@login');
    Route::post('/logout', 'LoginController@logout');
    Route::post('/password/email', 'ForgotPasswordController@sendResetLinkEmail');
    Route::post('/password/reset', 'ResetPasswordController@reset');
    Route::get('/refresh', 'LoginController@refresh');
    Route::post('/register', 'RegisterController@register');
});
