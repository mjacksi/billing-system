<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Accountant'], function () {
    Route::get('/home', 'SettingController@home')->name('home');
    //Set Local
    Route::get('lang/{local}', 'SettingController@lang')->name('switch-language');

    //Settings Management
    Route::get('settings', 'SettingController@settings')->name('settings.general');
    Route::post('settings', 'SettingController@updateSettings')->name('settings.updateSettings');
    Route::get('profile', 'SettingController@view_profile')->name('profile.show');
    Route::post('profile', 'SettingController@profile')->name('profile.update');


    //items Routes
    Route::resource('items', 'ItemController')->except([
        'edit', 'delete'
    ]);
    //Users Routes
    Route::resource('users', 'UserController')->except([
        'edit', 'delete'
    ]);

    //Bills Routes
    Route::resource('bills', 'BillController')->except([
        'edit', 'delete'
    ]);
    Route::post('bill-add-payment/{id}', 'BillController@addPayment')->name('bill.addPayment');

    //Expenses Routes
    Route::resource('expenses', 'ExpenseController')->except([
        'edit', 'delete'
    ]);

    //creditor_debtor Routes
    Route::resource('cds', 'CreditorDebtorController')->except([
        'edit', 'delete'
    ]);
    Route::post('cds/{id}', 'CreditorDebtorController@addPayment')->name('cds.addPayment');


    //Payments Routes
    Route::resource('payments', 'PaymentController')->except([
        'edit', 'delete'
    ]);


});
