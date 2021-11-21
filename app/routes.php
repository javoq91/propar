<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	$news = EmilioBravo\Blog\Article::where('status','=','published')->where('category_id','=',1)->take(6)->get();
	return View::make('site/partials/home')->with(compact('news','properties'));
});
Route::get('/contacto', function()
{
	return View::make('site/partials/contacto');
});
Route::get('/deseo-vender', function()
{
	return View::make('site/partials/deseo-vender');
});
//

// Platform RESTful route
Route::get('users/confirm/{code}', 'UsersController@getConfirm');
Route::get('users/reset_password/{token}', 'UsersController@getReset');
Route::get('users/reset_password', 'UsersController@postReset');
Route::get('users/forgot_password', 'UsersController@getForgot');
Route::post('users/forgot_password', 'UsersController@postForgot');
Route::controller( 'users', 'UsersController');

Route::group(['before'=> 'auth'],function(){

	Route::get('/mi-cuenta','MiCuentaController@getIndex');
	Route::get('/lotes/{lote_id}/add-to-cart','PaymentsController@addToCart');
	Route::get('/pay','PaymentsController@generateOrder');
	Route::get('/pago-online', function()
	{
		return View::make('site/partials/pago-online');
	});
});
