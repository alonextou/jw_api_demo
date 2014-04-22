<?php

namespace api\v1;

use App;
use Input;
use Controller;
use Response;

class ProductController extends Controller {

	public function getProducts()
	{
		$client = App::make('solrClient');
		$query = $client->createSelect();
		$query->createFilterQuery('catalog')->setQuery('solr_system_s:"IDS_Catalog" AND sf_meta_class:"Product"');
		$query->setStart(0)->setRows(1000);
		
		$facetSet = $query->getFacetSet();
		$facetSet->createFacetField('category')->setField('category_s');
		$facetSet->createFacetField('line')->setField('product_line_s');

		$query->setFields([
			'sf_meta_id',
			//'sf_meta_class',
			//'solr_system_s',
			'title_s',
			'image_s',
			'attrs_product_detail_s',
			//'attrs_standard_feature_s',
			'model_group_s',
			'category_s',
			'product_line_s',
			'material_s',
			'type_s',
			//'models_s'
		]);

		$fieldMap = [
			'sf_meta_id' => 'uid',
			//'sf_meta_class' => '_type',
			//'solr_system_s' => '_index',
			'title_s' => 'title',
			'image_s' => 'images',
			'attrs_product_detail_s' => 'description',
			//'attrs_standard_feature_s' => 'features',
			'model_group_s' => 'groups',
			'category_s' => 'categories',
			'product_line_s' => 'lines',
			'material_s_' => 'materials',
			'type_s' => 'styles',
			//'models_s' => 'models'
		];

		$result = $client->execute($query);

		$products = [];
		foreach ($result as $document) {
			$fields = [];
			foreach($document->getFields() as $field => $value)
			{	
				if(array_key_exists($field, $fieldMap))
				{
					//$fieldValue = is_array($value) ? json_encode($value) : $value;
					$fields[$fieldMap[$field]] = $value;
				}
			}
			$products[] = $fields;
		}

		//$facets = array();
		//$facets['categories'] = $result->getFacetSet()->getFacet('category');
		//$facets['lines'] = $result->getFacetSet()->getFacet('line');

		return Response::json($products);
	}

	public function getProduct($id)
	{
		$client = App::make('solrClient');
		$query = $client->createSelect();

		//TODO: change title_s to uri: $uri
		$query->createFilterQuery('catalog')->setQuery('solr_system_s:"IDS_Catalog" AND sf_meta_class:"Product" AND sf_meta_id:"' . $id . '"');

		// debug
		if(Input::get('debug'))
		{
			ini_set('xdebug.var_display_max_depth', -1);
			ini_set('xdebug.var_display_max_children', -1);
			ini_set('xdebug.var_display_max_data', -1);

			$result = $client->execute($query);
			foreach ($result as $document) {
				var_dump($document);
			}
			die;
		}

		$query->setFields([
			'sf_meta_id',
			//'sf_meta_class',
			//'solr_system_s',
			'title_s',
			'image_s',
			'attrs_product_detail_s',
			//'attrs_standard_feature_s',
			'model_group_s',
			'category_s',
			'product_line_s',
			'material_s',
			'type_s',
			//'models_s'
		]);

		$fieldMap = [
			'sf_meta_id' => 'uid',
			//'sf_meta_class' => '_type',
			//'solr_system_s' => '_index',
			'title_s' => 'title',
			'image_s' => 'images',
			'attrs_product_detail_s' => 'description',
			//'attrs_standard_feature_s' => 'features',
			'model_group_s' => 'groups',
			'category_s' => 'categories',
			'product_line_s' => 'lines',
			'material_s_' => 'materials',
			'type_s' => 'styles',
			//'models_s' => 'models'
		];

		$result = $client->execute($query);

		foreach ($result AS $document) {
			$product = [];
			foreach($document->getFields() as $field => $value)
			{	
				if(array_key_exists($field, $fieldMap))
				{
					//var_dump($value);
					//$fieldValue = is_array($value) ? json_encode($value) : $value;
					$product[$fieldMap[$field]] = $value;
				}
			}
			//$product['_index'] = 'catalog';
			//$product['_type'] = 'product';
			$product['description'] = $product['description'][0];
		}

		return Response::json($product);
	}

}