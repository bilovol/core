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

Route::get('/firstConnect', function () {
    return view('page.firstConnect');
});

// CONNECT
Route::prefix('/connect')->group(function () {
    Route::get('/', function () {
        return view('page.connect');
    });
    Route::get('/first', function () {
        return view('page.firstConnect');
    });
    Route::get('/get', 'ConnectController@getConnect');
    Route::post('/set', 'ConnectController@setConnect');
});


// SYNСRONIZATION
Route::prefix('/synсronization')->group(function () {
    Route::get('/', function () {
        return view('page.sync');
    });
    Route::get('/get', 'SyncController@getSync');
    Route::post('/set', 'SyncController@setSync');
});


// EXPORT
Route::prefix('/export')->group(function () {
    Route::get('/', function () {
        return view('page.export');
    });
    Route::get('/get', 'ExportController@getData');
    Route::post('/set', 'ExportController@doExport');
});
