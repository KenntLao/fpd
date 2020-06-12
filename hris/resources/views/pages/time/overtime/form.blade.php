@csrf
<div class="row">
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="workshift_name">Work Shift Name: </label>
			<span class="badge right badge-danger">Required</span>
			<div class="input">
				<p class="placeholder">Enter Work Shift Name</p>
				<input class="form-control required" type="text" name="workshift_name" value="{{old('work_shift_name') ?? $work_shift->workshift_name}}" required>
			</div>
		</div>
	</div>
</div>

@php
$monday_time_in = date('G:i A',$work_shift->monday_time_in);
$monday_time_out = date('G:i A',$work_shift->monday_time_out);
$tuesday_time_in = date('G:i A',$work_shift->tuesday_time_in);
$tuesday_time_out = date('G:i A',$work_shift->tuesday_time_out);
$wednesday_time_in = date('G:i A',$work_shift->wednesday_time_in);
$wednesday_time_out = date('G:i A',$work_shift->wednesday_time_out);
$thursday_time_in = date('G:i A',$work_shift->thursday_time_in);
$thursday_time_out = date('G:i A',$work_shift->thursday_time_out);
$friday_time_in = date('G:i A',$work_shift->friday_time_in);
$friday_time_out = date('G:i A',$work_shift->friday_time_out);
$saturday_time_in = date('G:i A',$work_shift->saturday_time_in);
$saturday_time_out = date('G:i A',$work_shift->saturday_time_out);
$sunday_time_in = date('G:i A',$work_shift->sunday_time_in);
$sunday_time_out = date('G:i A',$work_shift->sunday_time_out);
@endphp
<div class="row">
	<div class="col-12 col-md-6">
		<div class="form-group">
			<div class="form-check">
				<input class="form-check-input workshift_check" type="checkbox" name="monday_shift" @if($work_shift->monday_shift !== 0) checked @else @endif value="{{$work_shift->monday_shift ?? 1}}" id="defaultCheck1">
				<label class="form-check-label" for="defaultCheck1">
					Monday
				</label>
			</div>
			<div class="row shift_time">
				<div class="col-md-6">
					<label class="mr-2" for="time_in">Monday Time in: </label>
					<div class="input">
						<input class="form-control workshift_time" type="text" name="monday_time_in" value="@if($work_shift->monday_time_in) {{$monday_time_in}} @endif" required>
					</div>
				</div>
				<div class="col-md-6">
					<label class="mr-2" for="time_in">Monday Time Out: </label>
					<div class="input">
						<input class="form-control workshift_time" type="text" name="monday_time_out" value="@if($work_shift->monday_time_in) {{$monday_time_out}} @endif" required>
					</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="form-check">
				<input class="form-check-input workshift_check" type="checkbox" name="tuesday_shift" @if($work_shift->tuesday_shift !== 0) checked @else @endif value="{{$work_shift->tuesday_shift ?? 1}}" id="defaultCheck1">
				<label class="form-check-label" for="defaultCheck1">
					Tuesday
				</label>
			</div>
			<div class="row shift_time">
				<div class="col-md-6">
					<label class="mr-2" for="time_in">Tuesday Time in: </label>
					<div class="input">
						<input class="form-control workshift_time" type="text" name="tuesday_time_in" value="@if($work_shift->tuesday_time_in) {{$tuesday_time_in}} @endif" required>
					</div>
				</div>
				<div class="col-md-6">
					<label class="mr-2" for="time_in">Tuesday Time Out: </label>
					<div class="input">
						<input class="form-control workshift_time" type="text" name="tuesday_time_out" value="@if($work_shift->tuesday_time_out) {{$tuesday_time_out}} @endif" required>
					</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="form-check">
				<input class="form-check-input workshift_check" type="checkbox" name="wednesday_shift" @if($work_shift->wednesday_shift !== 0) checked @else @endif value="{{$work_shift->wednesday_shift ?? 1}}" id="defaultCheck1">
				<label class="form-check-label" for="defaultCheck1">
					Wednesday
				</label>
			</div>
			<div class="row shift_time">
				<div class="col-md-6">
					<label class="mr-2" for="time_in">Wednesday Time in: </label>
					<div class="input">
						<input class="form-control workshift_time" type="text" name="wednesday_time_in" value="@if($work_shift->wednesday_time_in) {{$wednesday_time_in}} @endif" required>
					</div>
				</div>
				<div class="col-md-6">
					<label class="mr-2" for="time_in">Wednesday Time Out: </label>
					<div class="input">
						<input class="form-control workshift_time" type="text" name="wednesday_time_out" value="@if($work_shift->wednesday_time_out) {{$wednesday_time_out}} @endif" required>
					</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="form-check">
				<input class="form-check-input workshift_check" type="checkbox" name="thursday_shift" @if($work_shift->thursday_shift !== 0) checked @else @endif value="{{$work_shift->thursday_shift ?? 1}}" id="defaultCheck1">
				<label class="form-check-label" for="defaultCheck1">
					Thursday
				</label>
			</div>
			<div class="row shift_time">
				<div class="col-md-6">
					<label class="mr-2" for="time_in">Thursday Time in: </label>
					<div class="input">
						<input class="form-control workshift_time" type="text" name="thursday_time_in" value="@if($work_shift->thursday_time_in) {{$thursday_time_in}} @endif" required>
					</div>
				</div>
				<div class="col-md-6">
					<label class="mr-2" for="time_in">Thursday Time Out: </label>
					<div class="input">
						<input class="form-control workshift_time" type="text" name="thursday_time_out" value="@if($work_shift->thursday_time_out) {{$thursday_time_out}} @endif" required>
					</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="form-check">
				<input class="form-check-input workshift_check" type="checkbox" name="friday_shift" @if($work_shift->friday_shift !== 0) checked @else @endif value="{{$work_shift->friday_shift ?? 1}}" id="defaultCheck1">
				<label class="form-check-label" for="defaultCheck1">
					Friday
				</label>
			</div>
			<div class="row shift_time">
				<div class="col-md-6">
					<label class="mr-2" for="time_in">Friday Time in: </label>
					<div class="input">
						<input class="form-control workshift_time" type="text" name="friday_time_in" value="@if($work_shift->friday_time_in) {{$friday_time_in}} @endif" required>
					</div>
				</div>
				<div class="col-md-6">
					<label class="mr-2" for="time_in">Friday Time Out: </label>
					<div class="input">
						<input class="form-control workshift_time" type="text" name="friday_time_out" value="@if($work_shift->friday_time_in) {{$friday_time_out}} @endif" required>
					</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="form-check">
				<input class="form-check-input workshift_check" type="checkbox" name="saturday_shift" @if($work_shift->saturday_shift !== 0) checked @else @endif value="{{$work_shift->saturday_shift ?? 1}}" id="defaultCheck1">
				<label class="form-check-label" for="defaultCheck1">
					Saturday
				</label>
			</div>
			<div class="row shift_time">
				<div class="col-md-6">
					<label class="mr-2" for="time_in">Saturday Time in: </label>
					<div class="input">
						<input class="form-control workshift_time" type="text" name="saturday_time_in" value="@if($work_shift->saturday_time_in) {{$saturday_time_in}} @endif" required>
					</div>
				</div>
				<div class="col-md-6">
					<label class="mr-2" for="time_in">Saturday Time Out: </label>
					<div class="input">
						<input class="form-control workshift_time" type="text" name="saturday_time_out" value="@if($work_shift->saturday_time_out) {{$saturday_time_out}} @endif" required>
					</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="form-check">
				<input class="form-check-input workshift_check" type="checkbox" name="sunday_shift" @if($work_shift->saturday_shift !== 0) checked @else @endif value="{{$work_shift->saturday_shift ?? 1}}" id="defaultCheck1">
				<label class="form-check-label" for="defaultCheck1">
					Sunday
				</label>
			</div>
			<div class="row shift_time">
				<div class="col-md-6">
					<label class="mr-2" for="time_in">Sunday Time in: </label>
					<div class="input">
						<input class="form-control workshift_time" type="text" name="sunday_time_in" value="@if($work_shift->sunday_time_in) {{$sunday_time_in}} @endif" required>
					</div>
				</div>
				<div class="col-md-6">
					<label class="mr-2" for="time_in">Sunday Time Out: </label>
					<div class="input">
						<input class="form-control workshift_time" type="text" name="sunday_time_out" value="@if($work_shift->sunday_time_out) {{$sunday_time_out}} @endif" required>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>