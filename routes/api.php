<?php

/**
 * API Rest - Demond on Demand
 */

Route::group(['namespace' => 'Api'], function () {

    //  Auth User
    Route::post('register', 'UserController@register');
    Route::post('login', 'UserController@login');
    Route::get('verify/{code}', 'UserController@verify');

    // Route::post('reset', 'ApiPasswordResetController@reset');
    Route::get('settings', 'SettingController@index');

    Route::group([
        'prefix' => 'user',
        'middleware' => 'auth:api',
    ], function () {

        # Demolitions data
        Route::get('demolition/{id}', 'DemolitionController@demolitionDescription');
        Route::get('demolitions', 'DemolitionController@index');

        # Data Profile
        Route::get('profile', 'UserController@profile');
        Route::post('update', 'UserController@update');
        Route::post('changePassword', 'UserController@changePassword');
        Route::post('logout', 'UserController@logout');


        Route::post('cancel', 'DemolitionController@cancelDemolition');
        Route::post('schedule', 'DemolitionController@scheduleDemolition');
        Route::post('quote', 'DemolitionController@quoteDemolition');

        Route::post('quote', 'DemolitionController@quoteDemolition');

        Route::post('answers', 'AnswerController@store');
        Route::post('demolitions', 'DemolitionController@store');

        //reset Password
        // Route::get('find/{token}', 'PasswordResetController@find');
        // Route::post('reset', 'PasswordResetController@reset');
    });
});


Route::group(['namespace' => 'Controller'], function () {

    // Password
    Route::post('create', 'PasswordResetController@create');
    Route::get('password/find/{token}', 'PasswordResetController@find');
    Route::post('reset', 'PasswordResetController@reset');

    // Payment
    Route::get('payment/status', 'PaymentController@getPaymentStatus')->name('payment_status');
    // Auth Payment
    Route::group(['prefix' => 'user', 'middleware' => 'auth:api'], function () {
        //create_payment
        # Payments
        Route::get('payments', 'PaymentController@index');
        Route::post('payment', 'PaymentController@create_payment');
        Route::post('refund', 'PaymentController@refund_deposit');
    });
});
