<?php
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('auth')->group(function() {
    Route::post('registro', 'AuthenticatorController@register');
    Route::post('login', 'AuthenticatorController@login');


    Route::middleware('auth:api')->group(function () {
        Route::post('logout', 'AuthenticatorController@logout');
    });
});

//Agrupamento de rotas
Route::prefix('contatos')->group(function() {
    Route::get('/','ContactsController@index')
        ->middleware('auth:api');

    Route::post('store', 'ContactsController@store')
        ->middleware('auth:api');

    Route::get('show/{id}', 'ContactsController@show')
        ->middleware('auth:api');

    Route::put('update/{id}','ContactsController@update')
        ->middleware('auth:api');

    Route::post('avatar', 'ContactsController@updateAvatar')
        ->middleware('auth:api');

    Route::delete('delete/{id}', 'ContactsController@destroy')
        ->middleware('auth:api');
});

