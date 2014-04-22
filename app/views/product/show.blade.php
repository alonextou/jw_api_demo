@extends('layouts.default')

@section('content')

	{{ Form::open(['action' => ['ProductController@update', $product['_id']], 'method' => 'put']) }}

		@foreach($product['_source'] as $field => $value)
			@if(!is_array($value))
				<input type="text" name="{{ $field }}" value="{{ $value }}">
			@else
				@foreach($value as $subValue)
					<input type="text" name="{{ $field }}[]" value="{{ $subValue }}">
				@endforeach
			@endif
		@endforeach

		<button type="submit">Save</button>

	{{ Form::close() }}

@stop