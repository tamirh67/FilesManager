<?php
/**
 * Created by PhpStorm.
 * User: Tamir
 * Date: 9/30/2015
 * Time: 8:49 AM
 */


Route::get('/mm', function () {
    return view('media-manager::test');
});


Route::get('/index', 'tamirh67\MediaManager\MediaController@index');
