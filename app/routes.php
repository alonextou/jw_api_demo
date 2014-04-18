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
	return Response::json(['version' => '0.1']);
});

Route::get('products', ['uses' => 'ProductController@getProducts']);
Route::get('products/{title}', ['uses' => 'ProductController@getProduct']);

Route::group(['prefix' => 'api/v1'], function()
{

});

/*
Route::get('/', function()
{
	echo 'Solarium library version: ' . Solarium\Client::VERSION . ' - ';

	return View::make('hello');
});
*/
