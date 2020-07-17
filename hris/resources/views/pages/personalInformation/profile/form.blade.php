@csrf
<div class="row" style="margin-bottom: 0;">
    <div class="col-12 col-md-2">
        <div class="form-group">
            <label class="mr-2 custom-file-upload" for="employee_photo">
                <div class="image-preview-container">
                    <img id="image-preview" src="
                    @if($id->employee_photo)
                    {{asset('/assets/images/employees/employee_photos/')}}/{{$id->employee_photo}}
                    @else
                    {{asset('/assets/images/employees/image-preview.png')}}
                    @endif
                    "  style="border: 1px solid #041E42" />
                    <div class="photo-overlay"></div>
                </div>
                <input accept="image/*" type="file" id="employee_photo" name="employee_photo" onchange="loadFile(event)">
                Photo (250px x 280px)
            </label>
        </div>
    </div>
    <div class="col-6">
        <div class="profile-text">
            <h4>{{$id->firstname}} {{$id->lastname}}</h4>
            <p><i class="fa fa-envelope mr-2"></i> {{$id->work_email}}</p>
        </div>
    </div>
</div>
<div class="row no-gutters" style="margin-bottom: 0;">
    <div class="col-12 col-md-4 mb-2">
        <label>Employee Number</label>
        <p>{{$id->employee_number}}</p>
    </div>
    <div class="col-12 col-md-4 mb-2">
        <label>PHIC</label>
        <p>{{$id->phic}}</p>
    </div>
    <div class="col-12 col-md-4 mb-2">
        <label>SSS</label>
        <p>{{$id->sss}}</p>
    </div>
</div>
<div class="row no-gutters section mb-4">
    <div class="col-12 section-title">
        <h5>personal information</h5>
    </div>
    <div class="col-12 section-info">
        <div class="row no-gutters">
            <div class="col-12 col-md-3">
                <label>PAGIBIG</label>
                <p>{{$id->sss}}</p>
            </div>
            <div class="col-12 col-md-3">
                <label>Date of Birth</label>
                <p>{{date("M d, Y", strtotime($id->birthday))}}</p>
            </div>
            <div class="col-12 col-md-3">
                <label>Gender</label>
                <p>{{$id->gender}}</p>
            </div>
            <div class="col-12 col-md-3">
                <label>Nationality</label>
                <p>{{$id->nationality}}</p>
            </div>
        </div>
        <div class="row no-gutters">
            <div class="col-12 col-md-3">
                <label>Marital Status</label>
                <p>{{$id->marital_status}}</p>
            </div>
            <div class="col-12 col-md-3">
                <label>Joined Date</label>
                <p>{{date("M d, Y", strtotime($id->joined_date))}}</p>
            </div>
        </div>
    </div>
</div>
<div class="row no-gutters section mb-4">
    <div class="col-12 section-title">
        <h5>contact information</h5>
    </div>
    <div class="col-12 section-info">
        <div class="row">
            <div class="col-12 col-md-3">
                <div class="form-group">
                    <label for="work_address">Work Address: </label>
                    <div class="input">
                        <p class="placeholder">Enter work address</p>
                        <textarea class="form-control" name="work_address">{{ old('work_address') ?? $id->work_address }}</textarea>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="form-group">
                    <label for="home_address">Home Address: </label>
                    <div class="input">
                        <p class="placeholder">Enter home address</p>
                        <textarea class="form-control" name="home_address">{{ old('home_address') ?? $id->home_address }}</textarea>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="form-group">
                    <label for="work_phone">Work Phone: </label>
                    <div class="input">
                        <p class="placeholder">Enter work phone</p>
                        <input class="form-control" type="text" name="work_phone" value="{{ old('work_phone') ?? $id->work_phone }}">
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="form-group">
                    <label for="private_email">Private Email: </label>
                    <div class="input">
                        <p class="placeholder">Enter private email</p>
                        <input class="form-control" type="text" name="private_email" value="{{ old('private_email') ?? $id->private_email }}">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row no-gutters section">
    <div class="col-12 section-title">
        <h5>job details</h5>
    </div>
    <div class="col-12 section-info">
        <div class="row no-gutters">
            <div class="col-12 col-md-3">
                <label>Job Title</label>
                <p>{{$id->job_title->name}}</p>
            </div>
            <div class="col-12 col-md-3">
                <label>Employment Status</label>
                <p>{{$id->employment_status}}</p>
            </div>
            <div class="col-12 col-md-3">
                <label>Supervisor</label>
                <p>
                    @php
                    if($id->supervisor) {
                    $supervisor = App\hris_employee::find($id->supervisor);
                    echo $supervisor->firstname.' '.$supervisor->lastname;
                    } else {
                    echo 'ADD SUPERVISOR';
                    }
                    @endphp
                </p>
            </div>
            <div class="col-12 col-md-3">
                <label>Department</label>
                <p>{{$id->department->name}}</p>
            </div>
        </div>
    </div>
</div>