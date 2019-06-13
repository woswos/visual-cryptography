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

Route::get('/', 'PagesController@index')->name('index');
Route::get('drag_images', 'PagesController@drag_images')->name('drag_images');
Route::get('/processDropzoneUpload', 'PagesController@processDropzoneUpload')->name('processDropzoneUpload');


Route::get('/session', 'SessionController@print')->name('session.print');
Route::get('/fileConverted', 'SessionController@fileConverted')->name('session.fileConverted');


Route::resource('v1', 'AppVersion1Controller');


Route::get('dropzone','PagesController@dropzone') ;
Route::post('dropzoneUpload',array('as'=>'dropzone.upload','uses'=>'PagesController@dropzoneUpload')) ;
