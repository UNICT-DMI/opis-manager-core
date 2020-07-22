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

Route::group(['prefix' => 'auth'], function() {

    Route::post('signup', 'Auth\AuthenticationController@signup')
        ->name('auth.signup'); 

    Route::post('login', 'Auth\AuthenticationController@login')
        ->name('auth.login'); 

    Route::post('logout', 'Auth\AuthenticationController@logout')
        ->name('auth.logout'); 
    
    Route::post('refresh', 'Auth\AuthenticationController@refresh')
        ->name('auth.refresh'); 

    Route::get('me', 'Auth\AuthenticationController@user')
        ->name('auth.me'); 
}); 

Route::group(['prefix' => 'v2'], function() {

    Route::get('dipartimento', 'DipartimentoController@index')
        ->name('dipartimento.index'); 
    
    Route::get('dipartimento/all', 'DipartimentoController@all')
        ->name('dipartimento.all'); 

    Route::get('dipartimento/{unictId}/cds', 'DipartimentoController@corsiDiStudi')
        ->name('dipartimento.corsi_di_studi'); 

    Route::get('dipartimento/with-id/{dipartimento}/cds', 'DipartimentoController@corsiDiStudiWithID')
        ->name('dipartimento.corsi_di_studi.withid'); 

    Route::get('cds', 'CorsoDiStudiController@index')
        ->name('cds.index');    

    Route::get('cds/all', 'CorsoDiStudiController@all')
        ->name('cds.all'); 

    Route::get('cds/{unictId}/insegnamenti', 'CorsoDiStudiController@insegnamenti')
        ->name('cds.insegnamenti');  

    Route::get('cds/with-id/{cds}/insegnamenti', 'CorsoDiStudiController@insegnamentiWithID')
        ->name('cds.insegnamenti.withid');

    Route::get('insegnamento', 'InsegnamentoController@index')
        ->name('insegnamento.index'); 

    Route::get('insegnamento/all', 'InsegnamentoController@all')
        ->name('insegnamento.all'); 

    Route::get('insegnamento/{codiceGomp}/schedeopis', 'InsegnamentoController@schedeOpis')
        ->name('insegnamento.schedeopis'); 

    Route::get('insegnamento/with-id/{insegnamento}/schedeopis', 'InsegnamentoController@schedeOpisWithID')
        ->name('insegnamento.schedeopis.withid'); 

    Route::get('domande', 'DomandeController@index')
        ->name('domande.index');
        
    Route::get('domande/{domanda}', 'DomandeController@index')
        ->name('domande.index');
        
}); 