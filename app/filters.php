<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	Session::flush();
	// Important! Must ensure indexes exist,
	// so that changing session does not lock user out of App.
	
	if (!Session::has('language'))
	{
	    Session::put('language', 'en');
	}

	if (!Session::has('catalog'))
	{
	    Session::put('catalog', 'jw');
	}

	App::singleton('solrClient', function()
	{
		$config = Config::get('solarium.config');
		return new Solarium\Client($config);
	});

	App::singleton('esClient', function()
	{

		$

		$params['hosts'] = Config::get('elasticsearch.hosts');
		$params['logging'] = true;
		$params['logPath'] = '/var/www/elasticsearch/logs/api.log';
		return new Elasticsearch\Client($params);
	});

	// TODO: REMOVE THIS!
	$client = App::make('esClient');
	try{
		$params['index'] = 'jw';
		$client->indices()->create($params);
		$params['index'] = 'jw_hd';
		$client->indices()->create($params);
	}catch(Exception $e){
		
	}
});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if (Auth::guest()) return Redirect::guest('login');
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});
