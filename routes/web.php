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
})->middleware('auth');

Route::get('verify/{code}', 'Api\UserController@verify');

Route::group(['namespace' => 'Controller'], function () {

    # Auth - Verify
    Route::post('login', 'UserController@authenticate')->name('login');
    Route::get('resetPassword', 'PasswordResetController@reset')->name('reset.password');

    # Home
    Route::get('home', 'HomeController@index')->name('home');

    # User
    Route::get('users', 'UserController@index')->name('users');
    Route::get('user', 'UserController@create')->name('createUser');
    Route::get('users/{id}', 'UserController@edit')->name('editUser');
    Route::put('updateUser/{id}', 'UserController@update')->name('user.update');

    # Payments
    Route::get('payments', 'PaymentController@index')->name('payments');

    # Demolition
    Route::get('demolitions', 'DemolitionsController@index')->name('demolitions');
    Route::get('demolitions/{demolition}/edit', 'DemolitionsController@edit')->name('demolitions.edit');
    Route::put('demolitions/{demolition}', 'DemolitionsController@update');
    Route::delete('demolitions/{demolition}', 'DemolitionsController@active')->name('demolitions.active');
    Route::post('demolitions', 'DemolitionsController@store');
    Route::get('images', 'DemolitionsController@home')->name('img');

    # Crud Notifications
    Route::get('notifications', 'NotificationController@index')->name('notifications');
    Route::post('notification', 'NotificationController@store')->name('notification');
    Route::delete('notification/{notification}', 'NotificationController@active')->name('notification.active');

    # Crud Questionis
    Route::get('questions', 'QuestionController@index')->name('questions');
    Route::get('question', 'QuestionController@create')->name('question');
    Route::post('question', 'QuestionController@store');
    Route::get('question/{question}/edit', 'QuestionController@edit')->name('question.edit');
    Route::put('question/{question}', 'QuestionController@update');
    Route::delete('question/{question}', 'QuestionController@active')->name('question.active');

    # Crud Advertisers
    Route::get('advertisers', 'AdvertiserController@index')->name('advertisers');
    Route::get('advertiser', 'AdvertiserController@create')->name('advertiser');
    Route::post('advertiser', 'AdvertiserController@store');
    Route::get('advertiser/{advertiser}/edit', 'AdvertiserController@edit')->name('advertiser.edit');
    Route::put('advertiser/{advertiser}', 'AdvertiserController@update');
    Route::delete('advertiser/{advertiser}', 'AdvertiserController@active')->name('advertiser.active');
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

    return json_decode((string) $response->getBody(), true);
});
