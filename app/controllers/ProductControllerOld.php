<?php

class ProductController extends BaseController {

	public function getProducts()
	{
		$request = Request::create('api/v2/products/', 'GET');
		$response = Route::dispatch($request)->getContent();
		$data['products'] = json_decode($response);

		return View::make('products/index', $data);
	}

	public function getProduct($id)
	{
		$request = Request::create('api/v2/products/' . $id, 'GET');
		$response = Route::dispatch($request)->getContent();
		$json = json_decode($response);

		$data['product'] = $json;
		
		return View::make('products/edit', $data);

		$fields = [];
		foreach($json->_source as $key => $value)
		{	
			$field = [];
			$field['name'] = $key;
			if(is_array($value))
			{
				$field['type'] = 'list';
				foreach($value as $listField){
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

		return View::make('products/edit', $data);
	}

}