{{-- resources/views/admin/dashboard.blade.php --}}
@extends('adminlte::page')
@section('title', 'HRIS | Recruitment - NPA')
@section('content_header')
<div class="row no-gutters">
	<div class="col-12 page-title">
		<h1><i class="fas fa-fw fa-columns"></i> recruitment</h1>
	</div>
</div>
@stop
@section('content')
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
<div class="card" id="create">
	<div class="card-header">
		<h3 class="card-title">
		@if($npa->sender)
		{{ucfirst($npa->sender->firstname)}} {{ucfirst($npa->sender->lastname)}}
		@else
		----
		@endif
		- NPA Request
		</h3>
		<div class="card-tools">
			<!-- SUPERVISOR AND DIRECTOR ROLE -->
			@if( $supervisor_id == $_SESSION['sys_id'] AND in_array($d_id, $sess_roles) )
			@if( $npa->status == 0 )
			<a class="btn btn-danger btn-md mr-1" href="/hris/pages/recruitment/npa/reject/{{$npa->id}}"><i class="fa fa-ban mr-1"></i> Reject</a>
			<a class="btn btn-success btn-md" href="/hris/pages/recruitment/npa/approve/{{$npa->id}}"><i class="fa fa-check mr-1"></i> Approve</a>
			@endif
			@if($npa->status == 1)
			<span class="badge-primary p-1">Processing</span>
			@endif
			@if( $npa->status == 2 )
			<span class="badge-success p-1">Approved</span>
			@endif
			@if( $npa->status == 3 )
			<span class="badge-danger p-1">Rejected</span>
			@endif
			<!-- ELSE IF ( HR RECRUITMENT ) -->
			@elseif ( in_array($hr_id, $sess_roles) )
			@if( $npa->status == 0 )
			<span class="badge-secondary p-1">Pending</span>
			@endif
			@if($npa->status == 1)
			<a class="btn btn-danger btn-md mr-1" href="/hris/pages/recruitment/npa/reject/{{$npa->id}}"><i class="fa fa-ban mr-1"></i> Reject</a>
			<a class="btn btn-success btn-md" href="/hris/pages/recruitment/npa/approve/{{$npa->id}}"><i class="fa fa-check mr-1"></i> Approve</a>
			@endif
			@if( $npa->status == 2 )
			<span class="badge-success p-1">Approved</span>
			@endif
			@if( $npa->status == 3 )
			<span class="badge-danger p-1">Rejected</span>
			@endif
			@else
			@if( $npa->status == 0 )
			<span class="badge-secondary p-1">Pending</span>
			@endif
			@if( $npa->status == 1 )
			<span class="badge-primary p-1">Processing</span>
			@endif
			@if( $npa->status == 2 )
			<span class="badge-success p-1">Approved</span>
			@endif
			@if( $npa->status == 3 )
			<span class="badge-danger p-1">Rejected</span>
			@endif
			@endif
		</div>
	</div>
	<div class="card-body">
		@if($npa->approve)
		<div class="row">
			<div class="col-12 col-md-6">
				<div class="form-group">
					<label>Approved by:</label>
					<p>
						@if($npa->approve)
						[{{$npa->approve->employee_number}}] {{ucfirst($npa->approve->firstname)}} {{ucfirst($npa->approve->lastname)}}
						@else
						----
						@endif
					</p>
				</div>
			</div>
		</div>
		@endif
		<div class="row">
			<div class="col-12 col-md-6">
				<div class="form-group">
					<label>Request Date:</label>
					<p>{{date('M d, Y', strtotime($npa->request_date))}}</p>
				</div>
			</div>
			<div class="col-12 col-md-6">
				<div class="form-group">
					<label>Effectivity Date:</label>
					<p>{{date('M d, Y', strtotime($npa->effectivity_date))}}</p>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-12 col-md-6">
				<div class="form-group">
					<label>Attention:</label>
					<p>{{$npa->attention}}</p>
				</div>
			</div>
			<div class="col-12 col-md-6">
				<div class="form-group">
					<label>Reference number:</label>
					<p>{{$npa->ref_no}}</p>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-12 col-md-6">
				<div class="form-group">
					<label>Project From:</label>
					<p>
						@if($npa->project_from)
						{{$npa->project_from->name}}
						@else
						----
						@endif
					</p>
				</div>
			</div>
			<div class="col-12 col-md-6">
				<div class="form-group">
					<label>Project to:</label>
					<p>
						@if($npa->project_to)
						{{$npa->project_to->name}}
						@else
						----
						@endif
					</p>
				</div>
			</div>
			<div class="col-12 col-md-6">
				<div class="form-group">
					<label>Reason:</label>
					<p>{{$npa->reason}}</p>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-12 col-md-6">
				<div class="form-group">
					<label>Designation from:</label>
					<p>
						@if($npa->designation_from)
						{{$npa->designation_from->name}}
						@else
						----
						@endif
					</p>
				</div>
			</div>
			<div class="col-12 col-md-6">
				<div class="form-group">
					<label>Designation to:</label>
					<p>
						@if($npa->designation_to)
						{{$npa->designation_to->name}}
						@else
						----
						@endif
					</p>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-12 col-md-6">
				<div class="form-group">
					<label>Basic salary from previous project:</label>
					<p>PHP {{$npa->bs_from}}</p>
				</div>
			</div>
			<div class="col-12 col-md-6">
				<div class="form-group">
					<label>Basic salary to:</label>
					<p>PHP {{$npa->bs_to}}</p>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-12 col-md-6">
				<div class="form-group">
					<label>Allowance from previous project:</label>
					<p>PHP {{$npa->a_from}}</p>
				</div>
			</div>
			<div class="col-12 col-md-6">
				<div class="form-group">
					<label>Allowance to:</label>
					<p>PHP {{$npa->a_to}}</p>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-12 col-md-6">
				<div class="form-group">
					<label>COLA from previous project:</label>
					<p>PHP {{$npa->cola_from}}</p>
				</div>
			</div>
			<div class="col-12 col-md-6">
				<div class="form-group">
					<label>COLA to:</label>
					<p>PHP {{$npa->cola_to}}</p>
				</div>
			</div>
		</div>
	</div>
	<div class="card-footer text-right">
		<a class="btn btn-default mr-1" href="/hris/pages/recruitment/npa/index"><i class="fa fa-arrow-left mr-1"></i> back</a>
	</div>
</div>
@stop
@section('css')
<link rel="stylesheet" href="{{ URL::asset('assets/css/admin_custom.css') }}">
@stop
@section('js')
<script src="{{ URL::asset('assets/js/main.js') }}"></script>
@stop