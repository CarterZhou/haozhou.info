<?php

Route::group(['prefix' => '/admin', 'namespace' => 'Admin'], function() {
    Route::get('/posts', 'PostController@index');
    Route::get('/posts/create', 'PostController@create');
    Route::post('/posts', 'PostController@store')->name('createPost');
    Route::get('/posts/{slug}', 'PostController@show')->name('postSingle');
    Route::delete('/posts/{id}', 'PostController@delete')->name('deletePost')->where('id', '[0-9]+');
});