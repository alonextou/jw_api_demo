<?php

class AttributeController extends Controller {

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
		$params['type'] = 'attribute';
		$params['body'] = '{
			"size": 100,
			"fields": ["title"],
			"query" : {
				"match" : {
					"language" : "'.Session::get('language').'"
				}
			}
		}';
		$response = $client->search($params);
		$data['attributes'] = $response['hits']['hits'];

		return View::make('attribute/index')->with($data);
	}

	public function create()
	{
		return View::make('attribute/create');		
	}

	public function store()
	{
		$input = Input::except('_method', '_token');
		$input['language'] = Session::get('language');

		$client = App::make('esClient');
		$params = array();
		$params['index'] = Session::get('catalog');
		$params['type']  = 'attribute';
		$params['body'] = $input;
		$result = $client->index($params);

		return Redirect::to('/attribute');
	}

	public function show($id)
	{
		$client = App::make('esClient');
		$params['index'] = Session::get('catalog');
		$params['type'] = 'attribute';
		$params['id'] = $id;
		$response = $client->get($params);
		try{
			$data['attribute'] = $response;
		}catch(Exception $e){
			// product not exist!!!!, make it???!??!?!?!
		}
	
		// over 1 result should never happen... think of an errmsg
		// TODO: if $data does not get set, it's possible to have Undefined variable: data Exeception!
		return View::make('attribute/show')->with($data);
	}

}