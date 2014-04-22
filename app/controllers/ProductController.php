<?php

class ProductController extends Controller {

	public function index()
	{
		$client = App::make('esClient');

		try {
			$params['index'] = Session::get('catalog');
			$client->indices()->create($params);
		} catch (Exception $e) {
			// ensure index existence
		}

		$params['index'] = Session::get('catalog');
		$params['type'] = 'product';
		$params['body'] = '{
			"size": 100,
			"fields": ["uid", "title"],
			"query" : {
				"match" : {
					"language" : "'.Session::get('language').'"
				}
			}
		}';
		$response = $client->search($params);
		$data['products'] = $response['hits']['hits'];

		return View::make('product/index')->with($data);
	}

	public function show($uid)
	{
		$client = App::make('esClient');
		$params['index'] = Session::get('catalog');
		$params['type'] = 'product';
		//$params['id'] = $id;
		$params['body'] = '{
			"query" : {
				"match" : {
					"uid": '.$uid.'
				}
			}
		}';
		// "language": '.Session::get('language').'
		$response = $client->search($params);
		try{
			$data['product'] = $response['hits']['hits'][0];
		}catch(Exception $e){
			// product not exist!!!!, make it???!??!?!?!
		}
	
		// over 1 result should never happen... right?
		
		return View::make('product/show')->with($data);
	}

	public function create()
	{
		return View::make('product/create');
	}

	public function store()
	{
		$input = Input::except('_method', '_token');
		$input['language'] = Session::get('language');

		$client = App::make('esClient');
		$params = [];
		$params['index'] = Session::get('catalog');
		$params['type'] = 'product';
		$params['body'] = $input;
		$response = $client->index($params);

		return Redirect::back(); // get and deliver response status
	}

	public function update($id)
	{
		$input = Input::except('_method', '_token');
		$input['language'] = Session::get('language');

		$client = App::make('esClient');
		$params = [];
		$params['index'] = Session::get('catalog');
		$params['type'] = 'product';
		$params['body'] = $input;
		$params['id'] = $id;
		$response = $client->index($params);

		return Redirect::back();
	}


}