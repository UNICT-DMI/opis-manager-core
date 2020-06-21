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

    Route::get('dipartimento/{unictId}/cds', 'DipartimentoController@corsiDiStudi')
        ->name('dipartimento.corsi_di_studi'); 

    Route::get('dipartimento/with-id/{dipartimento}/cds', 'DipartimentoController@corsiDiStudiWithID')
        ->name('dipartimento.corsi_di_studi.withid'); 

    Route::get('cds', 'CorsoDiStudiController@index')
        ->name('cds.index');    

    Route::get('cds/{unictId}/insegnamenti', 'CorsoDiStudiController@insegnamenti')
        ->name('cds.insegnamenti');  

    Route::get('cds/with-id/{cds}/insegnamenti', 'CorsoDiStudiController@insegnamentiWithID')
        ->name('cds.insegnamenti.withid');
}); 