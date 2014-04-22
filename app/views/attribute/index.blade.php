@extends('layouts.default')

@section('content')

	<a href="/attribute/create">Create</a>

	<hr>

	<table>
		@foreach($attributes as $attribute)
			<tr>
				<td>
					<a href="/attribute/{{ $attribute['_id'] }}">{{ $attribute['fields']['title'][0] }}</a>
				</td>
			</tr>
		@endforeach
	</table>


@stop