@extends('adminlte::page')
@section('title', 'HRIS | Benefits Administration - Employee Expenses')
@section('content_header')
<div class="row no-gutters">
    <div class="col-12 page-title">
        <h1><i class="fas fa-fw fa-columns"></i>Employee Expense</h1>
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
    @if ($employeeExpense->status == 0)
    <div class="card-header">
        <h3 class="card-title">employee expense - pending</h3>
    </div>
    @endif
    @if ($employeeExpense->status == 1)
    <div class="card-header" style="background: #28a745">
        <h3 class="card-title">employee expense - approved</h3>
    </div>
    @endif
    @if ($employeeExpense->status == 2)
    <div class="card-header" style="background: #dc3545">
        <h3 class="card-title">employee expense - denied</h3>
    </div>
    @endif
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-12 col-sm-2">
                <div class="profile-image mb-4">
                    <img src="{{ URL::asset('assets/images/employees/employee_photos/') }}/{{$employeeExpense->employee->employee_photo}}">
                </div>
            </div>
            <div class="col-12 col-sm-10">
                <div class="row">
                    <div class="col-12 col-sm-4">
                        <div class="form-group">
                            <label>Employee number:</label>
                            <p>{{$employeeExpense->employee->employee_number}}</p>
                        </div>
                    </div>
                    <div class="col-12 col-sm-4">
                        <div class="form-group">
                            <label>Department:</label>
                            <p>{{$employeeExpense->employee->department->name}}</p>
                        </div>
                    </div>
                    <div class="col-12 col-sm-4">
                        <div class="form-group">
                            <label>Work phone:</label>
                            <p>{{$employeeExpense->employee->work_phone}}</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-sm-4">
                        <div class="form-group">
                            <label>Employee name:</label>
                            <p>{{$employeeExpense->employee->firstname}} {{$employeeExpense->employee->lastname}}</p>
                        </div>
                    </div>
                    <div class="col-12 col-sm-4">
                        <div class="form-group">
                            <label>Private mail address:</label>
                            <p>{{$employeeExpense->employee->private_email}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row no-gutters section">
            <div class="col-12 section-title">
                <h5>information</h5>
            </div>
            <div class="col-12 section-info">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label>Expense Date: </label>
                            <p>{{$employeeExpense->expense_date}}</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label>Payment Method: </label>
                            <p>{{$employeeExpense->payment_method->name}}</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label>Transaction / Ref No: </label>
                            <p>{{$employeeExpense->ref_number}}</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label>Payee</label>
                            <p>{{$employeeExpense->payee}}</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label>Expense Category: </label>
                            <p>{{$employeeExpense->expense_category->name}}</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label>Notes: </label>
                            <p>{{$employeeExpense->notes}}</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label>Currency: </label>
                            <p>{{$employeeExpense->currency}}</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label>Amount: </label>
                            <p>{{$employeeExpense->amount}}</p>
                        </div>
                    </div>
                </div>
                @if($employeeExpense->attachment_1 != NULL ?? $employeeExpense->attachment_2 != NULL ?? $employeeExpense->attachment_3 != NULL)
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label>Attachments: </label>
                            @if($employeeExpense->attachment_1)
                            <p><a class="download-link" href="/hris/pages/admin/benefits/employeeExpenses/download/1/{{$employeeExpense->id}}" title="Download attachment"><i class="fas fa-cloud-download-alt mr-2"></i>{{$employeeExpense->attachment_1}}</a></p>
                            @endif
                            @if($employeeExpense->attachment_2)
                            <p><a class="download-link" href="/hris/pages/admin/benefits/employeeExpenses/download/2/{{$employeeExpense->id}}" title="Download attachment"><i class="fas fa-cloud-download-alt mr-2"></i>{{$employeeExpense->attachment_2}}</a></p>
                            @endif
                            @if($employeeExpense->attachment_3)
                            <p><a class="download-link" href="/hris/pages/admin/benefits/employeeExpenses/download/3/{{$employeeExpense->id}}" title="Download attachment"><i class="fas fa-cloud-download-alt mr-2"></i>{{$employeeExpense->attachment_3}}</a></p>
                            @endif
                        </div>
                    </div>
                </div>
                @else
                @endif
            </div>
        </div>
    </div>
    <div class="card-footer text-right">
        <a class="btn btn-default mr-1" href="{{URL::previous()}}"><i class="fa fa-arrow-left mr-1"></i> back</a>
    </div>
</div>
@stop
@section('css')
<link rel="stylesheet" href="{{ URL::asset('assets/css/admin_custom.css') }}">
@stop
@section('js')
<script src="{{ URL::asset('assets/js/main.js') }}"></script>
@stop