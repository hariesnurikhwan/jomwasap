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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::resource('generate', 'GenerateUrlController', ['parameters' => ['generate' => 'url'], 'middleware' => 'auth']);

Route::group(['domain' => 'hi.jomwasap.my'], function () {
    Route::get('{alias}', 'VisitUrlController@go')->middleware('CheckCookie');
});

Route::get('/go/{alias}', 'VisitUrlController@go')->middleware('CheckCookie');

Route::post('/lead', 'LeadController@index')->name('lead');
