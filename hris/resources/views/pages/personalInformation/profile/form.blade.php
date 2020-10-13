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
                    " style="border: 1px solid #041E42" />
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
        <div class="row">
            <div class="col-12 col-md-3">
                <label>PAGIBIG</label>
                <p>{{$id->pagibig}}</p>
            </div>
            <div class="col-12 col-md-3">
                <div class="form-group">
                    <label>Date of Birth</label>
                    <div class="input">
                        <p class="placeholder">Enter date of birth</p>
                        <input class="form-control" type="date" name="birthday" value="{{ old('birthday') ?? $id->birthday }}">
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="form-group">
                    <label>Gender</label>
                    <div class="input">
                        <select class="form-control  select2" name="gender">
                            <option disabled default selected {{ $id->gender == NULL ? 'selected' : '' }}>--select one--</option>
                            <option value="Male" {{ $id->gender == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female"{{ $id->gender == 'Female' ? 'selected' : '' }}>Female</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="form-group">
                    <label>Nationality</label>
                    <div class="input">
                        <p class="placeholder">Enter nationality</p>
                        <input class="form-control" type="text" name="nationality" value="{{ old('nationality') ?? $id->nationality }}">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-3">
                <div class="form-group">
                    <label>Marital Status</label>
                    <div class="input">
                        <select class="form-control  select2" name="marital_status">
                            <option disabled default selected {{ $id->marital_status == NULL ? 'selected' : '' }}>--select one--</option>
                            <option value="Single" {{ $id->marital_status == 'Single' ? 'selected' : '' }}>Single</option>
                            <option value="Married" {{ $id->marital_status == 'Married' ? 'selected' : '' }}>Married</option>
                            <option value="Widower" {{ $id->marital_status == 'Widower' ? 'selected' : '' }}>Widower</option>
                            <option value="Divorced" {{ $id->marital_status == 'Divorced' ? 'selected' : '' }}>Divorced</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="form-group">
                    <label>Joined date</label>
                    <p>{{date("M d, Y", strtotime($id->joined_date))}}</p>
                </div>
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
            <!--<div class="col-12 col-md-3">
                <label>Department</label>
                @if($id->department)
                    <p>{{$id->department->name}}</p>
                @endif
            </div> -->
        </div>
    </div>
</div>