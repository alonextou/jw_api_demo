@extends('layouts.default')

@section('content')

	<a href="/product/create">Create</a>

	<hr>

	<table>
		@foreach($products as $product)
			<tr>
				<td>
					<a href="/product/{{ $product['fields']['uid'][0] }}">{{ $product['fields']['title'][0] }}</a>
				</td>
			</tr>
		@endforeach
	</table>

@stop