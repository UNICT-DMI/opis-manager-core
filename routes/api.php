<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['prefix' => 'v2'], function() {

    Route::get('dipartimento', 'DipartimentoController@index')
        ->name('dipartimento.index'); 

    Route::get('dipartimento/{dipartimento}/cds', 'DipartimentoController@corsiDiStudi')
        ->name('dipartimento.corsi_di_studi'); 

}); 