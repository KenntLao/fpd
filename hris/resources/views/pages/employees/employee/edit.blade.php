{{-- resources/views/admin/dashboard.blade.php --}}
@extends('adminlte::page')
@section('title', 'HRIS | Employees - Employee')
@section('content_header')
<?php
$_SESSION['return_page'] = URL::previous();
?>
<div class="row no-gutters">
    <div class="col-12 page-title">
        <h1><i class="fas fa-fw fa-users"></i> Employee Management</h1>
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
@if ($message = Session::get('error'))
<div class="alert alert-danger alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <p><i class="fas fa-fw fa-ban"></i>{{ $message }}</p>
</div>
@endif
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Update Employee</h3>
    </div>
    <div class="card-body">
        <form class="form-horizontal" method="post" action="/hris/pages/employees/employee/update/{{$employee->id}}" enctype="multipart/form-data" id="form">
            @method('PATCH')
            @csrf
            @include('pages.employees.employee.form')
        </form>
    </div>
    <div class="card-footer text-right">
        <a class="btn btn-default mr-1" href="{{ URL::previous() }}"><i class="fa fa-arrow-left"></i>
            back</a>
        <button class="btn btn-success" type="submit" form="form"><i class="fa fa-upload"></i> save employee
            record</button>
    </div>
</div>
@stop
@section('css')
<link rel="stylesheet" href="{{ URL::asset('assets/css/admin_custom.css') }}">
@stop
@section('js')
<script src="{{ URL::asset('assets/js/main.js') }}"></script>
<script>
    $('#department_dropdown').on('change', function() {
        if ($(this).val() != '') {
            var department_id = $(this).val();
            var _token = $('input[name="_token"]').val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('getSupervisor.fetch')}}",
                method: "POST",
                data: {
                    _token: _token,
                    department_id: department_id,
                },
                success: function(response) {
                    $('#supervisor').html(response);
                }
            });
        }
    });
    //preview image
    var loadFile = function(event) {
        var output = document.getElementById('image-preview');
        output.src = URL.createObjectURL(event.target.files[0]);
        output.onload = function() {
            URL.revokeObjectURL(output.src) // free memory
        }
    };
    $(function(){
        var employee_type_val = $('#employee_type').val();
		if(employee_type_val == 1) {
            $('#employee_agency_con').hide();
        } else {
            $('#employee_agency_con').show();
        }
		
		$('#employee_type').change(function(){
			if(this.value == 2){
				$('#employee_agency_con').show();
			}else {
				$('#employee_agency_con').hide();
			}
			
		});
	});
</script>
@stop