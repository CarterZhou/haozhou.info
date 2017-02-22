<?php

Route::group(['prefix' => '/admin', 'namespace' => 'Admin'], function() {
    Route::get('/posts', 'PostController@index')->name('postList');
    Route::get('/posts/create', 'PostController@create')->name('createPost');
    Route::post('/posts', 'PostController@store')->name('storePost');
    Route::delete('/posts/{id}', 'PostController@delete')->name('deletePost')->where('id', '[0-9]+');
    Route::get('/posts/{slug}', 'PostController@show')->name('postSingle');
});