@extends('adminlte::page')
@section('title', 'HRIS | Leave Entitlement')
@section('content_header')
<div class="row no-gutters">
    <div class="col-12 page-title">
        <h1><i class="fas fa-fw fa-users "></i> leave entitlements</h1>
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
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Leave Entitlements</h3>
    </div>
    <div class="card-body">
        <div class="row">
            @foreach($leave_entitlements as $entitlement)
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            @if(isset($entitlement->leave_type->name))
                            {{$entitlement->leave_type->name}} Chart
                            @endif
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="chartjs-size-monitor">
                            <div class="chartjs-size-monitor-expand">
                                <div class=""></div>
                            </div>
                            <div class="chartjs-size-monitor-shrink">
                                <div class=""></div>
                            </div>
                        </div>
                        <canvas id="donutChart{{$entitlement->id}}" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 572px;" width="715" height="312" class="chartjs-render-monitor"></canvas>
                    </div>
                </div>
            </div>

            @endforeach

        </div>
    </div>
    <div class="card-footer">
    </div>
</div>
@stop
@section('css')
<link rel="stylesheet" href="{{ URL::asset('assets/css/admin_custom.css') }}">
@stop
@section('js')
@foreach($leave_entitlements as $entitlement)
@php
$id = $_SESSION['sys_id'];
$numberDays = 0;
$pending_leaves = App\hris_leaves::where('employee_id',$id)->where('status',0)->where('leave_type_id',$entitlement->leave_type_id)->get();
$approved_leaves = App\hris_leaves::where('employee_id', $id)->where('status', 1)->where('leave_type_id',$entitlement->leave_type_id)->get();

foreach($approved_leaves as $approved_leave) {
    $start_date = strtotime($approved_leave->leave_start_date);
    $end_date = strtotime($approved_leave->leave_end_date);
    $timeDiff = abs($end_date - $start_date);
    $days_diff = $timeDiff / 86400;
    $numberDays = $days_diff + 1;
}



$denied_leaves = App\hris_leaves::where('employee_id', $id)->where('status', 2)->where('leave_type_id',$entitlement->leave_type_id)->get();

$pending_count = count($pending_leaves);
$approved_count = $numberDays;
$denied_count = count($denied_leaves);

@endphp
<script>
    var donutChartCanvas = $("#donutChart" + JSON.parse("{{ json_encode($entitlement->id) }}")).get(0).getContext("2d")

    var donutData = {
        labels: [
            "Approved Leave Days:" + JSON.parse("{{ json_encode($approved_count) }}"),
            "Pending Leave: " + JSON.parse("{{ json_encode($pending_count) }}"),
            "Denied Leave: " + JSON.parse("{{ json_encode($denied_count) }}"),
            "Unused Leave Days: " + JSON.parse("{{ json_encode($entitlement->leave_credit) }}"),
        ],
        datasets: [{
            data: [JSON.parse("{{ json_encode($approved_count) }}"), JSON.parse("{{ json_encode($pending_count) }}"), JSON.parse("{{ json_encode($denied_count) }}"), JSON.parse("{{ json_encode($entitlement->leave_credit) }}")],
            backgroundColor: ["#f56954", "#00a65a", "#f39c12", "#00c0ef", "#3c8dbc", "#d2d6de"],
        }]
    }
    var donutOptions = {
        maintainAspectRatio: false,
        responsive: true,
    }
    var donutChart = new Chart(donutChartCanvas, {
        type: "doughnut",
        data: donutData,
        options: donutOptions
    });
</script>
@endforeach
<script>
    $(document).ready(function() {
        $('.delete-btn').on('click', function() {
            var get = $('.add-button').attr('href');
            var href = get.replace('create', 'delete');
            var target = $(this).attr('data-target');
            var modal_id = target.replace('#', '');
            var id = target.replace('#modal-', '');
            $('.modal').attr('id', modal_id);
            $('.modal').attr('aria-labelledby', modal_id);
            $('.form-horizontal').attr('action', href + '/' + id);
            $('.form-horizontal').attr('id', 'form-' + id);
            $('.modal-footer > button').attr('form', 'form-' + id);
            var name = $(this).attr('data-name');
            $('.data-name').text('Are you sure you want to delete ' + name + '?');
        });
    });
</script>
@stop