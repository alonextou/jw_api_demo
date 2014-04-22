@extends('layouts.solr')

@section('content')

	{{ Form::open(['url' => '/product', 'method' => 'post']) }}

		@foreach($product as $field => $value)
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