{{-- resources/views/admin/dashboard.blade.php --}}
@extends('adminlte::page')
@section('title', 'HRIS | Time Management - Attendance')
@section('header_js')

@stop
@section('content_header')
<div class="row no-gutters">
	<div class="col-12 page-title">
		<h1><i class="fas fa-fw fa-list-alt"></i> Time Management</h1>
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
@if (count($errors))
<div class="alert alert-danger">
	<strong>Whoops!</strong> There were some problems with your input.
	<ul>
		@foreach ($errors->all() as $error)
		<li>{{ $error }}</li>
		@endforeach
	</ul>
</div>
@endif
<div class="card">
	<div class="card-header">
		<h3 class="card-title">Attendance</h3>
		<div class="card-tools">
			<button class="btn add-button btn-md" data-toggle="modal" data-target="#snapModal">Punch In</button>
		</div>
	</div>
	<div class="card-body">
		@if(count($attendances) > 0)
		<div class="table-responsive">
			<table class="table table-hover table-bordered table-striped table-condensed">
				<thead>
					<tr>
						<th>time in</th>
						<th>time out</th>
					</tr>
				</thead>
				<tbody>
					@foreach($attendances as $attendance)
					<tr>
						<td>{{date("M d, Y - h:i:sa", strtotime($attendance->time_in))}}</td>
						<td>
							@if($attendance->time_out)
							{{date("M d, Y - h:i:sa", strtotime($attendance->time_in))}}
							@endif
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		@else
		<h4>No data available.</h4>
		@endif
	</div>
	<div class="card-footer">
		{{$attendances->links()}}
	</div>
	<div class="modal" id="snapModal">
		<div class="modal-dialog">
			<div class="modal-content">

				<!-- Modal Header -->
				<div class="modal-header">
					<h4 class="modal-title">Punch in</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<!-- Modal body -->
				<div class="modal-body">
					<form method="POST" action="/hris/pages/time/attendances" enctype="multipart/form-data">
						@csrf
						<div class="row">
							<div class="col-md-6">
								<div id="my_camera"></div>
								<input type="button" value="Take Photo" onClick="take_snapshot()">
								<input type="hidden" name="time_in_photo" class="image-tag" accept="image/*">
							</div>
							<div class="col-md-6">
								<div id="results">Captured image will appear here!</div>
							</div>
							<div class="col-md-12 text-center">
								<br />
								<button class="btn btn-success">Submit</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@stop
@section('css')
<link rel="stylesheet" href="{{ URL::asset('assets/css/admin_custom.css') }}">
@stop
@section('js')
<script src="{{asset('assets/js/jpeg_camera/webcam.js')}}" type="text/javascript"></script>

<script>
	Webcam.set({
		width: 150,
		height: 150,
		image_format: 'jpeg',
		jpeg_quality: 90
	});

	Webcam.attach('#my_camera');

	function take_snapshot() {
		Webcam.snap(function(data_uri) {
			$(".image-tag").val(data_uri);
			document.getElementById('results').innerHTML = '<img src="' + data_uri + '" />';
		});
	}
</script>
@stop