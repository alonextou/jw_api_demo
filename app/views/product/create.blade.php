@extends('layouts.default')

@section('content')

	{{ Form::open(['url' => 'product', 'method' => 'post']) }}

		<label>Title</label>
		
		<input type="text" name="title">

		<button type="submit">Save</button>

	{{ Form::close() }}

@stop