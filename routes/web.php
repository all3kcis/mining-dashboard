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

Route::get('/', 'Controller@home')->name('home');


Route::get('/miner/{id}', 'MinerController@show')->where('id','[0-9]+')->name('miner');
Route::get('/miner/{id}/sync_payments', 'MinerController@sync_payments')->where('id','[0-9]+')->name('miner_sync_payments');
Route::post('/miner', 'MinerController@store');
Route::post('/miner/{id}', 'MinerController@update')->where('id','[0-9]+')->name('miner_update');

Route::get('/miner/{id}/payments', 'PaymentController@showForMiner')->where('id','[0-9]+')->name('miner_payments');


Route::get('/coin/{id}', 'CoinController@show')->where('id','[0-9]+')->name('coin');
Route::post('/coin', 'CoinController@store');
Route::post('/coin/{id}', 'CoinController@update')->where('id','[0-9]+')->name('coin_update');
Route::get('/coin_sync/{id}', 'CoinController@sync')->where('id','[0-9]+')->name('coin_sync');