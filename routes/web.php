<?php
Route::group(['prefix' => '/admin', 'middleware' => ['forceSSL']], function () {

    Auth::routes();

    Route::group(['namespace' => 'Admin', 'middleware' => ['auth']], function () {

        Route::get('/', 'DashboardController@index')->name('dashboard');

        Route::get('/posts', 'PostController@index')->name('postList');
        Route::get('/posts/create', 'PostController@createView')->name('postCreateView');
        Route::post('/posts', 'PostController@create')->name('createPost');
        Route::delete('/posts/{id}', 'PostController@delete')->name('deletePost')->where('id', '[0-9]+');
        Route::get('/posts/{id}', 'PostController@updateView')->name('postUpdateView')->where('id', '[0-9]+');
        Route::post('/posts/{id}', 'PostController@update')->name('updatePost')->where('id', '[0-9]+');

        Route::get('/categories', 'CategoryController@index')->name('categoryList');
        Route::get('/categories/create', 'CategoryController@createView')->name('categoryCreateView');
        Route::post('/categories', 'CategoryController@create')->name('createCategory');
        Route::get('/categories/{id}', 'CategoryController@updateView')->name('categoryUpdateView')->where('id', '[0-9]+');
        Route::delete('/categories/{id}', 'CategoryController@delete')->name('deleteCategory')->where('id', '[0-9]+');
        Route::post('/categories/{id}', 'CategoryController@update')->name('updateCategory')->where('id', '[0-9]+');

        Route::get('/tags', 'TagController@index')->name('tagList');
        Route::get('/tags/create', 'TagController@createView')->name('tagCreateView');
        Route::post('/tags', 'TagController@create')->name('createTag');
        Route::get('/tags/{id}', 'TagController@updateView')->name('tagUpdateView')->where('id', '[0-9]+');
        Route::delete('/tags/{id}', 'TagController@delete')->name('deleteTag')->where('id', '[0-9]+');
        Route::post('/tags/{id}', 'TagController@update')->name('updateTag')->where('id', '[0-9]+');
    });
});

