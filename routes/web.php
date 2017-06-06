<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', 'HomeController@index');
Route::get('/post/{slug}', 'HomeController@showPost');
Route::post('/numbers/fetch','HomeController@fetchNumbers');
Route::post('/numbers/update', ['middleware' => 'auth', 'uses' => 'HomeController@updateNumbers']);
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/upvotes', ['middleware' => 'auth', 'uses' => 'HomeController@myUpvotes']);
Route::get('/recommends', ['middleware' => 'auth', 'uses' => 'HomeController@myRecommends']);

Route::group(['prefix' => config('backpack.base.route_prefix', 'admin'), 'middleware' => ['web', 'auth']], function () {
    CRUD::resource('source', 'Admin\SourceCrudController');
});
