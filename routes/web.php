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

/*Route::get('/', function () {
    return view('welcome');
});
 */
//Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');

Route::get('/', function() {
	return view('index');
});

Route::name('folders_path')->get('/carpetas', 'FolderController@index');
Route::name('folder_create_path')->get('/carpetas/crear', 'FolderController@create');
Route::name('folder_store_path')->post('/carpetas/crear', 'FolderController@store');
Route::name('folder_edit_path')->get('/carpetas/{carpeta}/editar', 'FolderController@edit');
Route::name('folder_update_path')->put('/carpetas/{carpeta}', 'FolderController@Update');
Route::name('folder_delete_path')->delete('/carpetas/{carpeta}', 'FolderController@delete');
Route::name('folder_show_path')->get('/carpetas/{carpeta}', 'FolderController@show');
