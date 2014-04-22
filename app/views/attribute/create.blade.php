@extends('layouts.default')

@section('content')

	{{ Form::open(['url' => 'attribute', 'method' => 'post']) }}

		<label>Title</label>
		<input type="text" name="title">

		<label>Values</label>
		<input type="text" name="values">

		<button type="submit">Save</button>

	{{ Form::close() }}

@stop