<?php

Route::group(['middleware' => ['api']], function () {

    Route::post('/auth/signup', 'AuthController@signup');
    Route::post('/auth/signin', 'AuthController@signin');

    Route::get('/tutorial', 'TutorialController@index');
    Route::get('/tutorial/{id}', 'TutorialController@show');

    Route::get('/address/provinsi', 'AddressController@getProvince');
    Route::get('/address/kabupaten/{id}', 'AddressController@getKabupaten');
    Route::get('/address/kecamatan/{id}', 'AddressController@getKecamatan');
    Route::get('/address/kelurahan/{id}', 'AddressController@getKelurahan');

    //article
    Route::get('/article', 'ArticleController@index');
    Route::get('/article/{id}', 'ArticleController@getById');

    Route::group(['middleware' => ['jwt.auth']], function () {
        Route::get('/profile', 'UserController@show');

        //tutorial
        Route::post('/tutorial', 'TutorialController@create');
        Route::put('/tutorial/{id}', 'TutorialController@update');
        Route::delete('/tutorial/{id}', 'TutorialController@destroy');

        //komentar
        Route::post('/comment/{id}', 'CommentController@store');

        //signout
        Route::post('/auth/signout', 'AuthController@signout');

        //user
        Route::get('/user/all', 'UserController@index');
        Route::get('/user/{id}', 'UserController@getByUser');
        Route::put('/user/verified/{id}', 'UserController@VerifiedAdmin');
        Route::put('/user/inactive/{id}', 'UserController@Inactive');
        Route::put('/user/active/{id}', 'UserController@Active');
        Route::put('/user/{id}', 'UserController@Update');

        //category
        Route::post('/category', 'CategoriesController@create');
        Route::put('/category/{id}', 'CategoriesController@update');
        Route::delete('/category/{id}', 'CategoriesController@delete');
        Route::get('/category/{id}', 'CategoriesController@getById');
        Route::get('/category', 'CategoriesController@index');
        Route::get('/categories_name', 'CategoriesController@categories_name');

        //tag
        Route::post('/tag', 'TagsController@create');
        Route::get('/tag/{id}', 'TagsController@getById');
        Route::get('/tag', 'TagsController@index');
        Route::put('/tag/{id}', 'TagsController@update');
        Route::delete('/tag/{id}', 'TagsController@delete');

        //address
        Route::post('/address', 'AddressController@create');
        Route::get('/address/{id}', 'AddressController@getById');
        Route::get('/address/user/{id}', 'AddressController@getByUser');
        Route::get('/address', 'AddressController@index');
        Route::delete('/address/{id}', 'AddressController@delete');
        Route::put('/address/{id}', 'AddressController@update');

        //article
        Route::post('/article', 'ArticleController@create');
        Route::delete('/article/{id}', 'ArticleController@delete');
        Route::put('/article/{id}', 'ArticleController@update');

        //gallery
        Route::post('/gallery', 'GalleryController@create');
        Route::delete('/gallery/{id}', 'GalleryController@delete');
        Route::put('/gallery/{id}', 'GalleryController@update');
    });
});
