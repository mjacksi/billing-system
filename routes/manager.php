<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Manager'], function () {
    Route::get('/home', 'SettingController@home')->name('home');
    //Set Local
    Route::get('lang/{local}', 'SettingController@lang')->name('switch-language');

    //Settings Management
    Route::get('settings', 'SettingController@settings')->name('settings.general');
    Route::post('settings', 'SettingController@updateSettings')->name('settings.updateSettings');
    Route::get('profile', 'SettingController@view_profile')->name('profile.show');
    Route::post('profile', 'SettingController@profile')->name('profile.update');


    //items Routes
    Route::resource('items', 'ItemController');


    //accountants Routes
    Route::resource('accountants', 'AccountantController');

    //Users Routes
    Route::resource('users', 'UserController');

    //Bills Routes
    Route::resource('bills', 'BillController');
    Route::post('bill-add-payment/{id}', 'BillController@addPayment')->name('bill.addPayment');

    //Expenses Routes
    Route::resource('expenses', 'ExpenseController');

    //creditor_debtor Routes
    Route::resource('cds', 'CreditorDebtorController');
    Route::post('cds/{id}', 'CreditorDebtorController@addPayment')->name('cds.addPayment');

    //cds2 Routes ديون المطلوبة من الناس
    Route::resource('cds2', 'CreditorDebtor2Controller');
    Route::post('cds2/{id}', 'CreditorDebtor2Controller@addPayment')->name('cds2.addPayment');


    //Payments Routes
    Route::resource('payments', 'PaymentController');

    //recipients Routes
    Route::resource('recipients', 'RecipientsController');


});
