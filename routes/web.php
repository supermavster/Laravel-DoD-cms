<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();
Route::get('/', function () {
    return view('welcome');
});

Route::get('/register/verify/{code}', 'Api\UserController@verify');

Route::group(['namespace' => 'Controller'], function () {
    Route::get('resetPassword', 'PasswordResetController@reset')->name('reset.password');

    Route::get('home', 'HomeController@index')->name('home');
    Route::get('demolition/{id}', 'DemolitionController@edit')->name('demolition.edit');
    Route::get('users', 'UserController@index')->name('users');
    Route::get('payments', 'PaymentController@index')->name('payment.index');
    Route::get('edit/{id}', 'DemolitionController@edit')->name('editDemolition');
    Route::get('edit/{id}', 'UserController@edit')->name('editUser');
    Route::put('updateUser/{id}', 'UserController@update')->name('user.update');
    Route::get('demolitions', 'DemolitionController@index')->name('demolitions.index');
    Route::put('updateDemolition/{id}', 'DemolitionController@update')->name('demolitions.update');

    Route::get('images', 'DemolitionController@home')->name('img');
    Route::get('user', 'UserController@create')->name('createUser');
});

Route::get('/redirect', function () {
    $query = http_build_query([
        'client_id' => 'client-id',
        'redirect_uri' => '/callback',
        'response_type' => 'code',
        'scope' => '',
    ]);

    return redirect('/oauth/authorize?' . $query);
});

Route::get('/callback', function (Request $request) {
    $http = new GuzzleHttp\Client;

    $response = $http->post('/oauth/token', [
        'form_params' => [
            'grant_type' => 'authorization_code',
            'client_id' => 'client-id',
            'client_secret' => 'client-secret',
            'redirect_uri' => '/callback',
            'code' => $request->code,
        ],
    ]);

    return json_decode((string)$response->getBody(), true);
});


