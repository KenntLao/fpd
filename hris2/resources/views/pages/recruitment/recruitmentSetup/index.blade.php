{{-- resources/views/admin/dashboard.blade.php --}}
@extends('adminlte::page')
@section('title', 'Dashboard')
@section('content_header')
<h1>Recruitment</h1>
@stop
@section('content')
<div class="row no-gutters">
	<div class="col-12 box">
		<div class="box-title">
			<h3>Recruitment Setup</h3>
		</div>
		<div class="box-add">
			<a href="{{ route('benefits.index') }}">Benefits</i></a>
			<a href="{{ route('employmentTypes.index') }}">Employment Types</i></a>
			<a href="{{ route('educationLevels.index') }}">Education Levels</i></a>
			<a href="{{ route('experienceLevels.index') }}">Experience Levels</i></a>
			<a href="{{ route('jobFunctions.index') }}">Job Functions</i></a>
		</div>
	</div>
</div>
@stop
@section('css')
<link rel="stylesheet" href="{{ URL::asset('assets/css/admin_custom.css') }}">
@stop
@section('js')
<script>
console.log('Hi!');
</script>
@stop