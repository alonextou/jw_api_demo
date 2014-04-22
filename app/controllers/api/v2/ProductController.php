<?php

namespace api\v2;

use App;
use Input;
use Controller;
use Response;
use Redirect;
use Session; // remove eventually

class ProductController extends Controller {

	public function getProduct($id)
	{
		$client = App::make('esClient');

		$getParams = array();
		//make "index" 1st URI and type 2nd... /catalog_jw_us/product/
		$getParams['index'] = Session::get('catalog');
		$getParams['type']  = 'product';
		$getParams['id']    = $id;
		$response = $client->get($getParams);

		return Response::json($response);
	}

	public function getProducts()
	{
		$client = App::make('esClient');
		$searchParams['index'] = Session::get('catalog');
		$searchParams['type']  = 'product';
		$searchParams['body']  = '{
			"size": 100,
			"fields": ["title"]
		}';

		$results = $client->search($searchParams);
		$products = $results['hits']['hits'];

		return Response::json($products);
	}


	public function createProducts()
	{	
		$input = Input::except('_method', '_token');

		if(Input::get('debug'))
		{
			var_dump($input);die;
		}

		$client = App::make('esClient');

		$params = array();
		$params['index'] = 'catalog_jw_us';
		$params['type']  = 'product';
		$params['body'] = json_encode($input);
		$result = $client->create($params);

		return Redirect::back();
	}

	public function updateProducts()
	{	
		$input = Input::except('_method', '_token');

		if(Input::get('debug'))
		{
			var_dump($input);die;
		}

		$client = App::make('esClient');

		$params = array();
		$params['index'] = 'catalog_jw_us';
		$params['type']  = 'product';
		$params['id'] = $input['id'];
		$params['body'] = '{
			"doc": '.json_encode($input)
		.'}';

		$result = $client->update($params);

		return Redirect::back();
	}


	// move to resourceful controller store method
	public function storeProducts()
	{
		$input = Input::except('_method', '_token');

		$client = App::make('esClient');

		$params = array();
		$params['index'] = 'catalog_jw_us';
		$params['type']  = 'product';
		$params['body'] = json_encode($input);
		$result = $client->create($params);

		var_dump($result);die;

		return Redirect::json();
	}

	public function deleteProducts()
	{	
		$client = App::make('esClient');

		$params = array();
		$params['index'] = 'catalog_jw_us';
		$params['type'] = 'product';
		$params['id'] = Input::get('id');
		$result = $client->delete($deleteParams);

		return Redirect::to('/products');
	}
}