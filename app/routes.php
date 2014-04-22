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
	return View::make('index');
});

Route::get('language/{id}', 'SessionController@setLanguage');
Route::get('catalog/{id}', 'SessionController@setCatalog');

//Route::get('products', 'ProductController@getProducts');
//Route::get('products/{id}', ['uses' => 'ProductController@getProduct']);

Route::resource('attribute', 'AttributeController');
Route::resource('product', 'ProductController');

/*
Route::get('attributes', 'AttributeController@getAttributes');
Route::get('attributes/create', ['uses' => 'AttributeController@getAttribute']);
Route::get('attributes/{id}', ['uses' => 'AttributeController@getAttribute']);
*/

Route::group(['prefix' => 'solr'], function()
{
	Route::get('/', 'SolrProductController@getProducts');

	// figure out ordering. thing/x will always override thing/{x}
	Route::get('product/migrate', 'SolrProductController@migrateProducts');

	Route::get('product', 'SolrProductController@getProducts');
	Route::get('product/{id}', ['uses' => 'SolrProductController@getProduct']);
});

Route::group(['prefix' => 'api/v1', 'namespace' => 'api\v1'], function()
{
	Route::get('/', function()
	{
		return Response::json(['version' => '1']);
	});

	Route::get('product', 'ProductController@getProducts');
	Route::get('product/{id}', ['uses' => 'ProductController@getProduct']);
});

Route::group(['prefix' => 'api/v2', 'namespace' => 'api\v2'], function()
{
	Route::get('/', function()
	{
		return Response::json(['version' => '2']);
	});
	Route::get('product', 'ProductController@getProducts');
	Route::get('product/{id}', 'ProductController@getProduct');
	Route::post('product', 'ProductController@createProducts');
	Route::put('product', 'ProductController@updateProducts');
	Route::delete('product', 'ProductController@deleteProducts');
});




/*
Route::get('/', function()
{
	echo 'Solarium library version: ' . Solarium\Client::VERSION . ' - ';

	return View::make('hello');
});
*/
