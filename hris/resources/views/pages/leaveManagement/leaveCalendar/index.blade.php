@extends('adminlte::page')
@section('title', 'HRIS | Leave Calendar')
@section('content_header')
<div class="row no-gutters">
    <div class="col-12 page-title">
        <h1><i class="fas fa-fw fa-users "></i> leave calendar</h1>
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var events = {!! json_encode($events) !!};
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: events,
        });
        calendar.render();
    });
</script>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Leave Calendar</h3>
    </div>
    <div class="card-body">
        <div class="row">
         <div class="col-md-1"></div>
            <div class="col-md-10">
                <div id="calendar"></div>
            </div>
            <div class="col-md-1"></div>
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