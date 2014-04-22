@extends('layouts.default')

@section('content')

	{{ Form::open(array('name' => 'product', 'url' => 'api/v2/product', 'method' => 'put')) }}

		@foreach($product->_source as $key => $val)
			
			@if(is_array($val))
				<fieldset>
					<legend>{{ $key }}</legend>
					@foreach($val as $value)
						<input name="{{ $key }}[]" type="text" value="{{ $value }}">
					@endforeach
				</fieldset>
			@else
				<label>{{ $key }}</label>
				<input name="{{ $key }}" type="text" value="{{ $val }}">
			@endif

		@endforeach

		<input type="hidden" name="id" value="{{ $product->_id }}">

		<button type="submit">Save</button>

	{{ Form::close() }}

@stop
