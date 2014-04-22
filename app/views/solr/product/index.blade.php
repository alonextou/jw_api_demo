@extends('layouts.solr')

@section('content')
	<button class="migrate">Migrate All</button>

	<table class="solr-products">
		@foreach($products as $product)
    		<tr>
    			<td>{{ $product->uid }}</td>
    			<td>
    				<a href="/solr/product/{{ $product->uid }}">{{ $product->title }}</a>
    			</td>
			</tr>
		@endforeach
	</table>
@stop