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
});

//categories
Route::get('/categories','CategoriesController@index');

Route::get('/categories/{id}','CategoriesController@getById');

Route::get('/categories_name','CategoriesController@categories_name');

Route::post('/categories','CategoriesController@create');

Route::put('/categories/{id}','CategoriesController@update');

Route::delete('/categories/{id}', 'CategoriesController@delete');

Route::get('/address/provinsi','AddressController@getProvince');

Route::get('/address/kabupaten/{id}','AddressController@getKabupaten');

Route::get('/address/kecamatan/{id}','AddressController@getKecamatan');

Route::get('/address/kelurahan/{id}','AddressController@getKelurahan');
