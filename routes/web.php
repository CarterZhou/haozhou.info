<?php

Route::get('/posts', 'PostController@index');
Route::get('/posts/create', 'PostController@create');
Route::post('/posts', 'PostController@store')->name('createPost');
Route::get('/posts/{slug}', 'PostController@show')->name('postSingle');