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

Route::name('api_folder_store_path')->post('/carpetas/crear', 'FolderController@store');

Route::name('api_folder_update_path')->post('/carpetas/', 'FolderController@Update');

Route::name('api_folder_delete_path')->delete('/carpetas/', 'FolderController@destroy');

Route::name('api_file_store_path')->post('/archivos/crear', 'FileController@store');

Route::name('api_file_update_path')->post('/archivos/', 'FileController@Update');

Route::name('api_file_delete_path')->delete('/archivos/', 'FileController@destroy');

Route::get('usuarios', 'UserController@get');
