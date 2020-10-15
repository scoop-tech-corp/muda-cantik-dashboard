<?php

// use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => ['api']], function () {

    Route::post('/auth/signup', 'AuthController@signup');
    Route::post('/auth/signin', 'AuthController@signin');

    Route::get('/tutorial', 'TutorialController@index');
    Route::get('/tutorial/{id}', 'TutorialController@show');

    Route::group(['middleware' => ['jwt.auth']], function ()
    {
        Route::get('/profile', 'UserController@show');

        //tutorial
        Route::post('/tutorial', 'TutorialController@create');
        Route::put('/tutorial/{id}', 'TutorialController@update');
        Route::delete('/tutorial/{id}', 'TutorialController@destroy');

        //komentar
        Route::post('/comment/{id}', 'CommentController@store');

        //signout
        Route::post('/auth/signout', 'AuthController@signout');

        //category
        Route::post('/category','CategoriesController@create');
        Route::put('/category/{id}','CategoriesController@update');
        Route::delete('/category/{id}', 'CategoriesController@delete');
        Route::get('/category/{id}','CategoriesController@getById');

        //tag
        Route::post('/tag','TagsController@create');
        Route::get('/tag/{id}','TagsController@getById');
        Route::get('/tag','TagsController@index');
        Route::put('/tag/{id}','TagsController@update');
        Route::delete('/tag/{id}', 'TagsController@delete');
    });
});

//categories
Route::get('/category','CategoriesController@index');



Route::get('/categories_name','CategoriesController@categories_name');

Route::post('/categories','CategoriesController@create');

Route::get('/address/provinsi','AddressController@getProvince');

Route::get('/address/kabupaten/{id}','AddressController@getKabupaten');

Route::get('/address/kecamatan/{id}','AddressController@getKecamatan');

Route::get('/address/kelurahan/{id}','AddressController@getKelurahan');
