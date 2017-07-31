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
Auth::routes();

Route::get('/', 'HomeController@index');
Route::get('/post/{slug}', 'HomeController@showPost');
Route::post('/numbers/fetch','HomeController@fetchNumbers');
Route::post('/numbers/update', ['middleware' => 'auth', 'uses' => 'HomeController@updateNumbers']);
Route::post('/saveTagsForLinks', ['middleware' => 'auth', 'uses' => 'HomeController@saveTagsForLinks']);

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/tag-data', 'TagController@getTagHoverData');
Route::get('/upvotes', ['middleware' => 'auth', 'uses' => 'HomeController@myUpvotes']);
Route::get('/my-bookmarks', ['middleware' => 'auth', 'uses' => 'HomeController@myRecommends']);
Route::get('/top-views', 'HomeController@topViews');
Route::get('/top-upvotes', 'HomeController@topUpvotes');
Route::get('/top-recommends', 'HomeController@topRecommends');
Route::get('/tag/{slug}', 'HomeController@showTaggedLinks');
Route::get('/tags', 'HomeController@showAllTags');

Route::get('/addTags', ['middleware' => 'auth', 'uses' => 'HomeController@addTags']);
// Route::get('search/autocomplete', ['as' => 'search-autocomplete', 'uses' => 'SearchController@autocomplete']);

Route::get('feedback', 'FeedbackController@index');
Route::post('feedback', ['as'=>'feedback.store','uses'=>'FeedbackController@storeFeedback']);

Route::group(['prefix' => config('backpack.base.route_prefix', 'admin'), 'middleware' => ['web', 'auth']], function () {
    CRUD::resource('source', 'Admin\SourceCrudController');
    CRUD::resource('links', 'Admin\LinksCrudController');
});

Route::get('/verifyemail/{token}', 'Auth\RegisterController@verify');

Route::get('feed', 'HomeController@createRssFeed');
Route::post('/track','HomeController@track');

// Route::get('/manage', ['middleware' => 'isUserAdmin', 'uses' => 'ManageController@index']);

Route::group(['prefix' => 'manage',  'middleware' => 'isUserAdmin'], function() {
	// Route::get('/', 'ManageController@index');
    // Route::get('links', 'ManageController@showLinks');
    Route::post ( '/delete-link', 'ManageController@deleteLink');
});