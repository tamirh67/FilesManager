<?php
/**
 * Created by PhpStorm.
 * User: Tamir
 * Date: 9/30/2015
 * Time: 8:49 AM
 */

Route::get('/index', 'tamirh67\MediaManager\MediaController@index');

// EX1
Route::get('/ex1', 'tamirh67\MediaManager\Ex1Controller@index');
Route::get('/ex1edit/{id}', 'tamirh67\MediaManager\Ex1Controller@edit');
Route::post('/ex1delete', array('as'=>'ex1delete', 'uses'=>'Ex1Controller@destroy') );
Route::get('/ex1form', function () {
    return view('media-manager::ex1_form');
});
Route::post('/ex1upload', 'tamirh67\MediaManager\MediaController@store');

// EX2
Route::post('/ex2delete', array('as'=>'ex2delete', 'uses'=>'tamirh67\MediaManager\Ex2Controller@destroy') );
Route::post('/ex2makeavatar', array('as'=>'makeavatar', 'uses'=>'tamirh67\MediaManager\Ex2Controller@makeAvatar') );
Route::get('/ex2edit/{id}', 'tamirh67\MediaManager\Ex2Controller@edit');
Route::get('/ex2', 'tamirh67\MediaManager\Ex2Controller@index');
Route::get('/ex2form', function () {
    return view('media-manager::ex2_form');
});
Route::post('/ex2upload', 'tamirh67\MediaManager\MediaController@store_ajax');


// GENERIC MEDIA
Route::post('/mediadelete', array('as'=>'documentdelete', 'uses'=>'tamirh67\MediaManager\MediaController@destroy') );
//Route::post('/mediadelete', 'tamirh67\MediaManager\MediaController@destroy' );
Route::get('/media/show/{id}', 'tamirh67\MediaManager\MediaController@show' );

