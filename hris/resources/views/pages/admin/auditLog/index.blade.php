{{-- resources/views/admin/dashboard.blade.php --}}
@extends('adminlte::page')
@section('title', 'HRIS | Administration - Audit Log')
@section('content_header')
<div class="row no-gutters">
	<div class="col-12 page-title">
		<h1><i class="fas fa-fw fa-random"></i> Audit Log</h1>
	</div>
</div>
@stop
@section('content')
@if ($message = Session::get('success'))
<div class="alert alert-success alert-block">
	<button type="button" class="close" data-dismiss="alert">×</button>
	<p><i class="fas fa-fw fa-check-circle"></i>{{ $message }}</p>
</div>
@endif
@if($errors->any())
<div class="alert alert-danger alert-block">
	<button type="button" class="close" data-dismiss="alert">×</button>
	<p><i class="fas fa-fw fa-exclamation-circle"></i>{{$errors->first()}}</p>
</div>
@endif
@if(count($logs) > 0)
@foreach($logs as $log)
<div class="card log mb-4">
	<div class="line"></div>
	<div class="card-body">
		<div class="log-icon mr-3">
			@if($log->action == 'login')
			<i class="fa fa-sign-in-alt"></i>
			@endif
			@if($log->action == 'add')
			<i class="fa fa-plus"></i>
			@endif
			@if($log->action == 'delete')
			<i class="fa fa-trash"></i>
			@endif
			@if($log->action == 'update')
			<i class="fa fa-pencil-alt"></i>
			@endif
		</div>
		<div class="log-info">
			<h5>{{date("M d, Y h:i:s a", strtotime($log->log_date_time))}}</h5>
			<p>{{$log->description}}</p>
		</div>
	</div>
</div>
@endforeach
@endif
<div class="links mb-2">
	{{$logs->links()}}
</div>
@stop
@section('css')
<link rel="stylesheet" href="{{ URL::asset('assets/css/admin_custom.css') }}">
@stop
@section('js')
<script type="text/javascript">
$(document).ready(function(){
	$('.container-fluid .log').last().children('.line').css('height', '0');
});
</script>
@stop