<?php

Route::group(['prefix' => '/admin', 'namespace' => 'Admin'], function() {
    Route::get('/posts', 'PostController@index')->name('postList');
    Route::get('/posts/create', 'PostController@create')->name('createPost');
    Route::post('/posts', 'PostController@store')->name('storePost');
    Route::delete('/posts/{id}', 'PostController@delete')->name('deletePost')->where('id', '[0-9]+');
    Route::get('/posts/{id}', 'PostController@update')->name('postSingle')->where('id', '[0-9]+');

    Route::get('/categories', 'CategoryController@index')->name('categoryList');
    Route::get('/categories/create', 'CategoryController@create')->name('createCategory');
    Route::delete('/categories/{id}', 'CategoryController@delete')->name('deleteCategory')->where('id', '[0-9]+');
});