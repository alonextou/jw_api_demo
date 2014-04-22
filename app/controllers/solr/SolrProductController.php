<?php

class SolrProductController extends BaseController {

	public function getProducts()
	{
		$request = Request::create('api/v1/product', 'GET');
		$response = Route::dispatch($request)->getContent();
		$products = json_decode($response);

		$data['products'] = $products;
		return View::make('solr/product/index', $data);
	}

	public function migrateProducts()
	{
		$input = Input::all();
		
		$request = Request::create('api/v1/product', 'GET');
		$response = Route::dispatch($request)->getContent();
		$products = json_decode($response);
		$client = App::make('esClient');

		foreach($products as $product){
			$product->language = Session::get('language');

			$params['body'][] = [
				'index' => [
					'_id' => $product->uid
				]
			];
			$params['body'][] = $product;
	
			/*
			$request = Request::create('api/v1/products/' . $product->id, 'GET');
			$response = Route::dispatch($request)->getContent();

			$client = App::make('esClient');
			$params = array();
			$params['index'] = Session::get('catalog');
			$params['type'] = 'product';
			$params['body'] = $response;
			$result = $client->index($params);
			*/
		}

		$params['index'] = Session::get('catalog');
		$params['type'] = 'product';
		$response = $client->bulk($params);

		var_dump($response);die;

		return Response::json('done');
		return Redirect::back();
	}

	public function getProduct($id)
	{
		$request = Request::create('api/v1/product/' . $id, 'GET');
		$response = Route::dispatch($request)->getContent();

		/*
		$fields = [];
		foreach($json as $key => $value)
		{	
			$field = [];
			$field['name'] = $key;
			if(is_array(json_decode($value)))
			{
				$field['type'] = 'list';
				foreach(json_decode($value) as $listField){
					$field['listFields'][] = $listField;
				}
				$fields[] = View::make('fields/list', ['field' => $field])->render();
			} else {
				$field['type'] = 'text';
				$field['value'] = $value;
				$fields[] = View::make('fields/text', ['field' => $field])->render();
			}
		}
		$data['fields'] = $fields;
		*/

		$data['product'] = json_decode($response);
		return View::make('solr/product/edit', $data);
	}

}