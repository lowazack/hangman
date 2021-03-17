<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('login', 'App\Http\Controllers\AuthController@login');
Route::post('register', 'App\Http\Controllers\AuthController@register');

Route::group(['middleware' => 'auth.api'], function() {
    Route::get('logout', 'App\Http\Controllers\AuthController@logout');
    Route::get('new-game', );
});
