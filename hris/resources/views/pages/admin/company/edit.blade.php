{{-- resources/views/admin/dashboard.blade.php --}}
@extends('adminlte::page')
@section('title', 'HRIS | Administration - Company Structure')
@section('content_header')
@stop
@section('content')
<div class="row no-gutters">
	<div class="col-12 offset-md-3 col-md-6 form-title">
		<h3>add department</h3>
	</div>
	<div class="col-12 offset-md-3 col-md-6 box">
		<div class="form-box">
			<form class="form-horizontal" method="post" action="/pages/admin/company/update/{{$company->id}}">
				@csrf
				@method('PATCH')
				<div class="form-group">
					<label for="name">Name: <span>*</span></label>
					<input class="form-control" type="text" value="{{$company->name}}" name="name" required>
				</div>
				<div class="form-group">
					<label for="details">Details: <span>*</span></label>
					<textarea class="form-control" name="details"required>{{$company->details}}</textarea>
				</div>
				<div class="form-group">
					<label for="name">Address: </label>
					<textarea class="form-control" name="address">{{$company->address}}</textarea>
				</div>
				<div class="row no-gutters">
					<div class="col-6">
						<div class="form-group">
							<label for="type">Type: <span>*</span></label>
							<select class="form-control select2" name="type" required>
								@foreach($types as $type)
								<option value='{{$type->name}}' {{ $company->type == $type->name  ? 'selected' : '' }}>{{$type->name}}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="col-6">
						<div class="form-group">
							<label for="country">Country</label>
							<select class="form-control select2" name="country" required>
								@foreach($countries as $country)
								<option value='{{$country->name}}' {{ $company->country == $country->name  ? 'selected' : '' }}>{{$country->name}}</option>
								@endforeach
							</select>
						</div>
					</div>
				</div>
				<div class="row no-gutters">
					<div class="col-6">
						<div class="form-group">
							<label for="timezone">Time Zone: <span>*</span></label>
							<select class="form-control select2" name="timezone" required>
								@foreach($timezones as $timezone)
								<option value="{{$timezone->name}}" {{ $company->timezone == $timezone->name  ? 'selected' : '' }}>{{$timezone->utc}} {{$timezone->name}}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="col-6">
						<div class="form-group">
							<label for="type">Parent Structure: <span>*</span></label>
							@if (count($companies) > 0)
							<select class="form-control select2" name="parent_structure">
								@foreach($companies as $company)
								<option value="{{$company->name}}">{{$company->name}}</option>
								@endforeach
							</select>
							@else
							<select class="form-control select2" name="parent_structure">
								<option value="None">None</option>
							</select>
							@endif
							</select>
						</div>
					</div>
				</div>
				<a href="/pages/admin/company/index">Back</a>
				<button type="submit">submit</button>
			</form>
		</div>
	</div>
</div>
@stop
@section('css')
<link rel="stylesheet" href="{{ URL::asset('assets/css/admin_custom.css') }}">
@stop
@section('js')
<script>
$(document).ready(function() {
    $('.select2').select2();
});
</script>
@stop