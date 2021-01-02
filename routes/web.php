<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => 'localWeb'], function () {
    Route::get('lang/{local}', function ($local) {
        session(['lang' => $local]);
        if (Auth::check())
            $user = Auth::user()->update(['local' => $local,]);

        app()->setLocale($local);
        return back();
    })->name('switch-language');
});


Auth::routes();

Route::group(['prefix' => 'manager'], function () {
    Route::get('/login', 'ManagerAuth\LoginController@showLoginForm')->name('manager.login');
    Route::post('/login', 'ManagerAuth\LoginController@login');
    Route::post('/logout', 'ManagerAuth\LoginController@logout')->name('logout');
});


Route::group(['prefix' => 'accountant'], function () {
    Route::get('/login', 'Accountant\AccountantAuth\LoginController@showLoginForm')->name('accountant.login');
    Route::post('/login', 'Accountant\AccountantAuth\LoginController@login');
    Route::post('/logout', 'Accountant\AccountantAuth\LoginController@logout')->name('logout');
});

Route::group(['prefix' => 'client'], function () {
    Route::get('/login', 'Client\ClientAuth\LoginController@showLoginForm')->name('client.login');
    Route::post('/login', 'Client\ClientAuth\LoginController@login');
    Route::post('/logout', 'Client\ClientAuth\LoginController@logout')->name('logout');
});


Route::get('migrate', function () {
    Artisan::call('migrate');
});
Route::get('cache', function () {
    Artisan::call('config:clear');
    Artisan::call('config:cache');
});


Route::fallback(function () {
    return redirect()->route('manager.login');
});


