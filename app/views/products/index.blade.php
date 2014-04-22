@extends('layouts.default')

@section('content')

	<div class="large-3 columns panel">
		<b>Filters</b>
	</div>
	
	<div class="large-9 columns">
		<table class="products">
			@foreach($products as $product)
				<tr>
					<td>
						<a href="/product/{{ $product->_id }}">{{ $product->fields->title[0] }}</a>
					</td>
				</tr>	
			@endforeach
		</table>
	</div>

@stop