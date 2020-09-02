<div class="row">
    <div class="col-md-2 col-sm-12">
        <div class="form-group">
            <label class="mr-2 custom-file-upload" for="employee_photo">
                <div class="image-preview-container">
                    <img id="image-preview" src="
                    @if($employee->employee_photo)
                        {{asset('/assets/images/employees/employee_photos/')}}/{{$employee->employee_photo}}
                    @else
                        {{asset('/assets/images/employees/image-preview.png')}}
                    @endif
                    " />
                    <div class="photo-overlay"></div>
                </div>
                <input class="" accept="image/*" type="file" id="employee_photo" name="employee_photo" onchange="loadFile(event)">
                Photo (250px x 280px)
            </label>

        </div>
    </div>
    <div class="col-md-10">
        <div class="row">
            <div class="col-md-5">
                <div class="form-group">
                    <label class="mr-2" for="employee_number">Employee Number</label>

                    <div class="input">
                        <p class="placeholder">Employee Number</p>
                        <input class="form-control " type="text" name="employee_number" value="{{old('employee_number') ?? $employee->employee_number}}">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label class="mr-2" for="employee_first_name">Employee First Name </label>

                    <div class="input">
                        <p class="placeholder">Employee First Name</p>
                        <input class="form-control " type="text" name="firstname" value="{{old('firstname') ?? $employee->firstname}}">
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="mr-2" for="employee_middle_name">Employee Middle Name </label>
                    <div class="input">
                        <p class="placeholder">Employee Middle Name</p>
                        <input class="form-control " type="text" name="middlename" value="{{old('middlename') ?? $employee->middlename}}">
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="mr-2" for="employee_last_name">Employee Last Name </label>

                    <div class="input">
                        <p class="placeholder">Employee Last Name</p>
                        <input class="form-control " type="text" name="lastname" value="{{old('lastname') ?? $employee->lastname}}">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-5">
                <div class="form-group">
                    <label class="mr-2" for="job_title">Job Title</label>

                    <select class="form-control  select2" name="job_title">
                        @if($employee->job_title_id)
                        <option value="{{$employee->job_title->id}}" default selected>{{$employee->job_title->name}}</option>
                        @else
                        <option disabled default selected>--select one--</option>
                        @endif
                        @foreach($job_titles as $job_title)
                        <option value="{{$job_title->id}}">{{$job_title->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label class="mr-2" for="work_mobile">Work Mobile </label>

            <div class="input">
                <p class="placeholder">Work Mobile</p>
                <input class="form-control " type="text" name="work_no" value="{{old('work_no') ?? $employee->work_no}}">
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label class="mr-2" for="work_phone">Work Phone </label>
            <div class="input">
                <p class="placeholder">Work Phone</p>
                <input class="form-control " type="text" name="work_phone" value="{{old('work_phone') ?? $employee->work_phone}}">
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label class="mr-2" for="work_email">Work Email </label>

            <div class="input">
                <p class="placeholder">Work Phone</p>
                <input class="form-control " type="email" name="work_email" value="{{old('work_email') ?? $employee->work_email}}">
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label class="mr-2" for="department">Department </label>

            <select id="department_dropdown" class="form-control  select2" name="department">

                @if($employee->department)
                @foreach($departments as $department)
                <option value="{{$department->id}}" {{$employee->department_id == $department->id ? 'selected' : ''}}>{{$department->name}}</option>
                @endforeach
                @else
                <option disabled default selected>--select one--</option>
                @foreach($departments as $department)
                <option value="{{$department->id}}" {{$employee->department_id == $department->id ? 'selected' : ''}}>{{$department->name}}</option>
                @endforeach
                @endif
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label class="mr-2" for="supervisor">Supervisor </label>
            <select id="supervisor" class="form-control select2" name="supervisor">
                @if(isset($supervisor))
                <option value="{{$supervisor->employee_number}}">{{$supervisor->firstname}} {{$supervisor->lastname}}</option>
                @else
                <option default disabled selected>--select one--</option>
                @endif
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label class="mr-2" for="supervisor">Pay Grade </label>
            <select id="pay_grade" class="form-control select2" name="pay_grade">

                @if(!$employee->pay_grade)
                <option default disabled selected>-- select one --</option>
                @foreach($pay_grades as $pay_grade)
                <option value="{{$pay_grade->id}}" {{$employee->pay_grade == $pay_grade->id ? 'selected' : ''}}>{{$pay_grade->name}}</option>
                @endforeach
                @else
                @foreach($pay_grades as $pay_grade)
                <option value="{{$pay_grade->id}}" {{$employee->pay_grade == $pay_grade->id ? 'selected' : ''}}>{{$pay_grade->name}}</option>
                @endforeach
                @endif
            </select>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab">Work Information</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab">Private Information</a>
            </li>
        </ul><!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane active" id="tabs-1" role="tabpanel">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="mr-2" for="work_address">Work Address </label>

                            <div class="input">
                                <p class="placeholder">Work Address</p>
                                <input class="form-control " type="text" name="work_address" value="{{old('work_address') ?? $employee->work_address}}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="mr-2" for="tin">TIN </label>

                            <div class="input">
                                <p class="placeholder">TIN</p>
                                <input class="form-control " type="text" name="tin" value="{{old('tin') ?? $employee->tin}}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="mr-2" for="sss">SSS </label>
                            <div class="input">
                                <p class="placeholder">SSS</p>
                                <input class="form-control " type="text" name="sss" value="{{old('sss') ?? $employee->sss}}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="mr-2" for="pagibig">Pag-ibig </label>
                            <div class="input">
                                <p class="placeholder">Pag-ibig</p>
                                <input class="form-control " type="text" name="pagibig" value="{{old('pagibig') ?? $employee->pagibig}}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="mr-2" for="phic">PHIC </label>
                            <div class="input">
                                <p class="placeholder">PHIC</p>
                                <input class="form-control " type="text" name="phic" value="{{old('phic') ?? $employee->phic}}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="mr-2" for="joined_date">Joined Date </label>

                            <div class="input">
                                <input class="form-control " type="date" name="joined_date" value="{{old('joined_date') ?? $employee->joined_date}}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="mr-2" for="employment_status">Employment Status</label>

                            <select class="form-control  select2" name="employment_status">
                                @if(!$employee->employment_status)
                                <option default disabled selected>-- select one --</option>
                                @foreach($employment_statuses as $employment_status)
                                <option value="{{$employment_status->name}}" {{$employee->employment_status == $employment_status->name ? 'selected' : ''}}>{{$employment_status->name}}</option>
                                @endforeach
                                @else
                                @foreach($employment_statuses as $employment_status)
                                <option value="{{$employment_status->name}}" {{$employee->employment_status == $employment_status->name ? 'selected' : ''}}>{{$employment_status->name}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="mr-2" for="termination_date">Termination Date </label>
                            <div class="input">
                                <input class="form-control " type="date" name="termination_date" value="{{old('termination_date') ?? $employee->termination_date}}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="mr-2" for="roles">Roles</label>

                            <select class=" select-role" name="role[]" multiple="multiple">
                                @if(count($roles) > 0)
                                @foreach($roles as $role)
                                <option value="{{$role->id}}" {{in_array($role->id, $role_ids) ? 'selected' : ''}}>
                                    {{$role->role_name}}
                                </option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="tabs-2" role="tabpanel">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <h3>Private Contact</h3>
                        </div>
                        <div class="form-group">
                            <label class="mr-2" for="address">Address </label>

                            <div class="input">
                                <p class="placeholder">Address</p>
                                <input class="form-control " type="text" name="home_address" value="{{old('home_address') ?? $employee->home_address}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="mr-2" for="email">Email </label>

                            <div class="input">
                                <p class="placeholder">Email</p>
                                <input class="form-control " type="email" name="private_email" value="{{old('private_email') ?? $employee->private_email}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="mr-2" for="home_work_distance">Km Home-Work </label>
                            <div class="input">
                                <p class="placeholder">Kilometer Home - Work</p>
                                <input class="form-control " type="number" name="home_distance" value="{{old('home_distance') ?? $employee->home_distance}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <h3>Marital Status</h3>
                        </div>
                        <div class="form-group">
                            <label class="mr-2" for="marital_status">Marital Status </label>

                            <select class="form-control  select2" name="marital_status">
                                @if($employee->marital_status)
                                <option default selected>{{$employee->marital_status}}</option>
                                @else
                                <option disabled default selected>--select one--</option>
                                @endif
                                <option value="single">Single</option>
                                <option value="married">Married</option>
                                <option value="widower">Widower</option>
                                <option value="divorced">Divorced</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <h3>Emergency</h3>
                        </div>
                        <div class="form-group">
                            <label class="mr-2" for="emergency_contact">Emergency Contact</label>

                            <div class="input">
                                <p class="placeholder">Emergeny Contact</p>
                                <input class="form-control " type="text" name="emergency_contact" value="{{old('emergency_contact') ?? $employee->emergency_contact}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="mr-2" for="emergency_phone">Emergency Phone</label>

                            <div class="input">
                                <p class="placeholder">Emergeny Phone</p>
                                <input class="form-control " type="text" name="emergency_no" value="{{old('emergency_no') ?? $employee->emergency_no}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <h3>Education</h3>
                        </div>
                        <div class="form-group">
                            <label class="mr-2" for="marital_status">Certificate Level </label>

                            <select class="form-control  select2" name="cert_level">
                                @if(!$employee->cert_level)
                                <option default disabled selected>-- select one --</option>
                                @foreach($certifications as $cert)
                                <option value="{{$cert->name}}" {{$employee->cert_level == $cert->name ? 'selected' : ''}}>{{$cert->name}}</option>
                                @endforeach
                                @else
                                @foreach($certifications as $cert)
                                <option value="{{$cert->name}}" {{$employee->cert_level == $cert->name ? 'selected' : ''}}>{{$cert->name}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="mr-2" for="field_study">Field of Study</label>

                            <div class="input">
                                <p class="placeholder">Field of Study</p>
                                <input class="form-control " type="text" name="field_study" value="{{old('field_study') ?? $employee->field_study}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="mr-2" for="school">School</label>

                            <div class="input">
                                <p class="placeholder">School</p>
                                <input class="form-control " type="text" name="school" value="{{old('school') ?? $employee->school}}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <h3>Citizenship</h3>
                        </div>
                        <div class="form-group">
                            <label class="mr-2" for="nationality">Nationality </label>

                            <select class="form-control  select2" name="nationality">
                                @if($employee->nationality)
                                <option default selected>{{$employee->nationality}}</option>
                                @else
                                <option disabled default selected>--select one--</option>
                                @endif
                                <option value="afghan">Afghan</option>
                                <option value="albanian">Albanian</option>
                                <option value="algerian">Algerian</option>
                                <option value="american">American</option>
                                <option value="andorran">Andorran</option>
                                <option value="angolan">Angolan</option>
                                <option value="antiguans">Antiguans</option>
                                <option value="argentinean">Argentinean</option>
                                <option value="armenian">Armenian</option>
                                <option value="australian">Australian</option>
                                <option value="austrian">Austrian</option>
                                <option value="azerbaijani">Azerbaijani</option>
                                <option value="bahamian">Bahamian</option>
                                <option value="bahraini">Bahraini</option>
                                <option value="bangladeshi">Bangladeshi</option>
                                <option value="barbadian">Barbadian</option>
                                <option value="barbudans">Barbudans</option>
                                <option value="batswana">Batswana</option>
                                <option value="belarusian">Belarusian</option>
                                <option value="belgian">Belgian</option>
                                <option value="belizean">Belizean</option>
                                <option value="beninese">Beninese</option>
                                <option value="bhutanese">Bhutanese</option>
                                <option value="bolivian">Bolivian</option>
                                <option value="bosnian">Bosnian</option>
                                <option value="brazilian">Brazilian</option>
                                <option value="british">British</option>
                                <option value="bruneian">Bruneian</option>
                                <option value="bulgarian">Bulgarian</option>
                                <option value="burkinabe">Burkinabe</option>
                                <option value="burmese">Burmese</option>
                                <option value="burundian">Burundian</option>
                                <option value="cambodian">Cambodian</option>
                                <option value="cameroonian">Cameroonian</option>
                                <option value="canadian">Canadian</option>
                                <option value="cape verdean">Cape Verdean</option>
                                <option value="central african">Central African</option>
                                <option value="chadian">Chadian</option>
                                <option value="chilean">Chilean</option>
                                <option value="chinese">Chinese</option>
                                <option value="colombian">Colombian</option>
                                <option value="comoran">Comoran</option>
                                <option value="congolese">Congolese</option>
                                <option value="costa rican">Costa Rican</option>
                                <option value="croatian">Croatian</option>
                                <option value="cuban">Cuban</option>
                                <option value="cypriot">Cypriot</option>
                                <option value="czech">Czech</option>
                                <option value="danish">Danish</option>
                                <option value="djibouti">Djibouti</option>
                                <option value="dominican">Dominican</option>
                                <option value="dutch">Dutch</option>
                                <option value="east timorese">East Timorese</option>
                                <option value="ecuadorean">Ecuadorean</option>
                                <option value="egyptian">Egyptian</option>
                                <option value="emirian">Emirian</option>
                                <option value="equatorial guinean">Equatorial Guinean</option>
                                <option value="eritrean">Eritrean</option>
                                <option value="estonian">Estonian</option>
                                <option value="ethiopian">Ethiopian</option>
                                <option value="fijian">Fijian</option>
                                <option value="filipino">Filipino</option>
                                <option value="finnish">Finnish</option>
                                <option value="french">French</option>
                                <option value="gabonese">Gabonese</option>
                                <option value="gambian">Gambian</option>
                                <option value="georgian">Georgian</option>
                                <option value="german">German</option>
                                <option value="ghanaian">Ghanaian</option>
                                <option value="greek">Greek</option>
                                <option value="grenadian">Grenadian</option>
                                <option value="guatemalan">Guatemalan</option>
                                <option value="guinea-bissauan">Guinea-Bissauan</option>
                                <option value="guinean">Guinean</option>
                                <option value="guyanese">Guyanese</option>
                                <option value="haitian">Haitian</option>
                                <option value="herzegovinian">Herzegovinian</option>
                                <option value="honduran">Honduran</option>
                                <option value="hungarian">Hungarian</option>
                                <option value="icelander">Icelander</option>
                                <option value="indian">Indian</option>
                                <option value="indonesian">Indonesian</option>
                                <option value="iranian">Iranian</option>
                                <option value="iraqi">Iraqi</option>
                                <option value="irish">Irish</option>
                                <option value="israeli">Israeli</option>
                                <option value="italian">Italian</option>
                                <option value="ivorian">Ivorian</option>
                                <option value="jamaican">Jamaican</option>
                                <option value="japanese">Japanese</option>
                                <option value="jordanian">Jordanian</option>
                                <option value="kazakhstani">Kazakhstani</option>
                                <option value="kenyan">Kenyan</option>
                                <option value="kittian and nevisian">Kittian and Nevisian</option>
                                <option value="kuwaiti">Kuwaiti</option>
                                <option value="kyrgyz">Kyrgyz</option>
                                <option value="laotian">Laotian</option>
                                <option value="latvian">Latvian</option>
                                <option value="lebanese">Lebanese</option>
                                <option value="liberian">Liberian</option>
                                <option value="libyan">Libyan</option>
                                <option value="liechtensteiner">Liechtensteiner</option>
                                <option value="lithuanian">Lithuanian</option>
                                <option value="luxembourger">Luxembourger</option>
                                <option value="macedonian">Macedonian</option>
                                <option value="malagasy">Malagasy</option>
                                <option value="malawian">Malawian</option>
                                <option value="malaysian">Malaysian</option>
                                <option value="maldivan">Maldivan</option>
                                <option value="malian">Malian</option>
                                <option value="maltese">Maltese</option>
                                <option value="marshallese">Marshallese</option>
                                <option value="mauritanian">Mauritanian</option>
                                <option value="mauritian">Mauritian</option>
                                <option value="mexican">Mexican</option>
                                <option value="micronesian">Micronesian</option>
                                <option value="moldovan">Moldovan</option>
                                <option value="monacan">Monacan</option>
                                <option value="mongolian">Mongolian</option>
                                <option value="moroccan">Moroccan</option>
                                <option value="mosotho">Mosotho</option>
                                <option value="motswana">Motswana</option>
                                <option value="mozambican">Mozambican</option>
                                <option value="namibian">Namibian</option>
                                <option value="nauruan">Nauruan</option>
                                <option value="nepalese">Nepalese</option>
                                <option value="new zealander">New Zealander</option>
                                <option value="ni-vanuatu">Ni-Vanuatu</option>
                                <option value="nicaraguan">Nicaraguan</option>
                                <option value="nigerien">Nigerien</option>
                                <option value="north korean">North Korean</option>
                                <option value="northern irish">Northern Irish</option>
                                <option value="norwegian">Norwegian</option>
                                <option value="omani">Omani</option>
                                <option value="pakistani">Pakistani</option>
                                <option value="palauan">Palauan</option>
                                <option value="panamanian">Panamanian</option>
                                <option value="papua new guinean">Papua New Guinean</option>
                                <option value="paraguayan">Paraguayan</option>
                                <option value="peruvian">Peruvian</option>
                                <option value="polish">Polish</option>
                                <option value="portuguese">Portuguese</option>
                                <option value="qatari">Qatari</option>
                                <option value="romanian">Romanian</option>
                                <option value="russian">Russian</option>
                                <option value="rwandan">Rwandan</option>
                                <option value="saint lucian">Saint Lucian</option>
                                <option value="salvadoran">Salvadoran</option>
                                <option value="samoan">Samoan</option>
                                <option value="san marinese">San Marinese</option>
                                <option value="sao tomean">Sao Tomean</option>
                                <option value="saudi">Saudi</option>
                                <option value="scottish">Scottish</option>
                                <option value="senegalese">Senegalese</option>
                                <option value="serbian">Serbian</option>
                                <option value="seychellois">Seychellois</option>
                                <option value="sierra leonean">Sierra Leonean</option>
                                <option value="singaporean">Singaporean</option>
                                <option value="slovakian">Slovakian</option>
                                <option value="slovenian">Slovenian</option>
                                <option value="solomon islander">Solomon Islander</option>
                                <option value="somali">Somali</option>
                                <option value="south african">South African</option>
                                <option value="south korean">South Korean</option>
                                <option value="spanish">Spanish</option>
                                <option value="sri lankan">Sri Lankan</option>
                                <option value="sudanese">Sudanese</option>
                                <option value="surinamer">Surinamer</option>
                                <option value="swazi">Swazi</option>
                                <option value="swedish">Swedish</option>
                                <option value="swiss">Swiss</option>
                                <option value="syrian">Syrian</option>
                                <option value="taiwanese">Taiwanese</option>
                                <option value="tajik">Tajik</option>
                                <option value="tanzanian">Tanzanian</option>
                                <option value="thai">Thai</option>
                                <option value="togolese">Togolese</option>
                                <option value="tongan">Tongan</option>
                                <option value="trinidadian or tobagonian">Trinidadian or Tobagonian</option>
                                <option value="tunisian">Tunisian</option>
                                <option value="turkish">Turkish</option>
                                <option value="tuvaluan">Tuvaluan</option>
                                <option value="ugandan">Ugandan</option>
                                <option value="ukrainian">Ukrainian</option>
                                <option value="uruguayan">Uruguayan</option>
                                <option value="uzbekistani">Uzbekistani</option>
                                <option value="venezuelan">Venezuelan</option>
                                <option value="vietnamese">Vietnamese</option>
                                <option value="welsh">Welsh</option>
                                <option value="yemenite">Yemenite</option>
                                <option value="zambian">Zambian</option>
                                <option value="zimbabwean">Zimbabwean</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="mr-2" for="gender">Gender </label>

                            <select class="form-control  select2" name="gender">
                                @if($employee->gender)
                                <option default selected>{{$employee->gender}}</option>
                                @else
                                <option disabled default selected>--select one--</option>
                                @endif
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="mr-2" for="birthday">Date of Birth </label>

                            <div class="input">
                                <input class="form-control " type="date" name="birthday" value="{{old('birthday') ?? $employee->birthday}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="mr-2" for="place_birth">Place of Birth </label>

                            <div class="input">
                                <p class="placeholder">Place of Birth</p>
                                <input class="form-control " type="text" name="place_birth" value="{{old('place_birth') ?? $employee->place_birth}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <h3>Dependant</h3>
                        </div>
                        <div class="form-group">
                            <label class="mr-2" for="dependant">Number of Children</label>
                            <div class="input">
                                <p class="placeholder">Number of Children</p>
                                <input class="form-control " type="number" name="dependant" min="0" value="{{old('dependant') ?? $employee->dependant}}">
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>