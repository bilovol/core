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

// CONNECT
Route::prefix('/connect')->group(function () {
    Route::get('/', function () {
        return view('page.connect');
    })->middleware('valid-connect');
    Route::post('/set', 'ConnectController@setConnect')->middleware('valid-connect');
    Route::get('/drop', 'ConnectController@disconnect')->middleware('valid-connect');
});


// SYNСRONIZATION
Route::prefix('/synсronization')->group(function () {
    Route::get('/', function () {
        return view('page.sync');
    })->middleware('valid-connect')->middleware('check-sp-connect');
    Route::get('/get', 'SyncController@getSync')->middleware('valid-connect');
    Route::post('/set', 'SyncController@setSync')->middleware('valid-connect');
    Route::post('/delete', 'SyncController@deleteSync')->middleware('valid-connect');
});


// EXPORT
Route::prefix('/export')->group(function () {
    Route::get('/', function () {
        return view('page.export');
    })->middleware('valid-connect')->middleware('check-sp-connect');
    Route::get('/get', 'ExportController@getData')->middleware('valid-connect');
    Route::post('/set', 'ExportController@doExport')->middleware('valid-connect');
});

//BX24
Route::post('/login','BitrixController@login');
