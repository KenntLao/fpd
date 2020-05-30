{{-- resources/views/admin/dashboard.blade.php --}}
@extends('adminlte::page')
@section('title', 'HRIS | Employees - Employee')
@section('content_header')
<div class="row no-gutters">
	<div class="col-12 page-title">
		<h1><i class="fas fa-fw fa-users"></i> Employee Management</h1>
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
<div class="card">
	<div class="card-header">
		<h3 class="card-title">Create Employee</h3>
	</div>
	<div class="card-body">
		<form class="form-horizontal" method="post" action="/hris/pages/employees/employee" enctype="multipart/form-data" id="form">
			@csrf
			<div class="row">
				<div class="col-md-2 col-sm-12">
					<div class="form-group">
						<label class="mr-2 custom-file-upload" for="employee_photo">
							<div class="image-preview-container">
								<img id="image-preview" src="{{asset('/assets/images/employees/image-preview.png')}}" />
								<div class="photo-overlay"></div>
							</div>
							<input class="required" accept="image/*" type="file" id="employee_photo" name="employee_photo" onchange="loadFile(event)" required>
							Photo (250px x 280px)
							<span class="badge badge-danger">Required</span>
						</label>

					</div>
				</div>
				<div class="col-md-7">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="mr-2" for="employee_number">Employee Number</label>
								<span class="badge badge-danger">Required</span>
								<div class="input">
									<p class="placeholder">Employee Number</p>
									<input class="form-control required" type="text" name="employee_number" value="{{old('employee_number') ?? $employees->employee_number}}" required>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label class="mr-2" for="employee_first_name">Employee First Name </label>
								<span class="badge badge-danger">Required</span>
								<div class="input">
									<p class="placeholder">Employee First Name</p>
									<input class="form-control required" type="text" name="firstname" value="{{old('firstname') ?? $employees->firstname}}" required>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label class="mr-2" for="employee_middle_name">Employee Middle Name </label>
								<div class="input">
									<p class="placeholder">Employee Middle Name</p>
									<input class="form-control required" type="text" name="middlename" value="{{old('middlename') ?? $employees->middlename}}">
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label class="mr-2" for="employee_last_name">Employee Last Name </label>
								<span class="badge badge-danger">Required</span>
								<div class="input">
									<p class="placeholder">Employee Last Name</p>
									<input class="form-control required" type="text" name="lastname" value="{{old('lastname') ?? $employees->lastname}}" required>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="mr-2" for="job_postion">Job Positions </label>
								<span class="badge badge-danger">Required</span>
								<div class="input">
									<p class="placeholder">Job Position</p>
									<input class="form-control required" type="text" name="job_position" value="{{old('job_position') ?? $employees->job_position}}" required>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-5"></div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label class="mr-2" for="work_mobile">Work Mobile </label>
						<span class="badge badge-danger">Required</span>
						<div class="input">
							<p class="placeholder">Work Mobile</p>
							<input class="form-control required" type="text" name="work_no" value="{{old('work_no') ?? $employees->work_no}}" required>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="mr-2" for="work_phone">Work Phone </label>
						<div class="input">
							<p class="placeholder">Work Phone</p>
							<input class="form-control required" type="text" name="work_phone" value="{{old('work_phone') ?? $employees->work_phone}}">
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="mr-2" for="work_email">Work Email </label>
						<span class="badge badge-danger">Required</span>
						<div class="input">
							<p class="placeholder">Work Phone</p>
							<input class="form-control required" type="email" name="work_email" value="{{old('work_email') ?? $employees->work_email}}" required>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label class="mr-2" for="department">Department </label>
						<span class="badge badge-danger">Required</span>
						<select class="form-control required select2" name="department" required>
							<option disabled default selected>--select one--</option>
							<option value="sample">sample</option>
							<option value="sample">sample</option>
							<option value="sample">sample</option>
							<option value="sample">sample</option>
						</select>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="mr-2" for="supervisor">Supervisor </label>
						<span class="badge badge-danger">Required</span>
						<select class="form-control required select2" name="supervisor" required>
							<option disabled default selected>--select one--</option>
							<option value="sample">sample</option>
							<option value="sample">sample</option>
							<option value="sample">sample</option>
							<option value="sample">sample</option>
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
										<span class="badge badge-danger">Required</span>
										<div class="input">
											<p class="placeholder">Work Address</p>
											<input class="form-control required" type="text" name="work_address" value="{{old('work_address') ?? $employees->work_address}}" required>
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
											<input class="form-control required" type="text" name="sss" value="{{old('sss') ?? $employees->sss}}">
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label class="mr-2" for="pagibig">Pag-ibig </label>
										<div class="input">
											<p class="placeholder">Pag-ibig</p>
											<input class="form-control required" type="text" name="pagibig" value="{{old('pagibig') ?? $employees->pagibig}}">
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label class="mr-2" for="phic">PHIC </label>
										<div class="input">
											<p class="placeholder">PHIC</p>
											<input class="form-control required" type="text" name="phic" value="{{old('phic') ?? $employees->phic}}">
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label class="mr-2" for="joined_date">Joined Date </label>
										<span class="badge badge-danger">Required</span>
										<div class="input">
											<input class="form-control required" type="date" name="joined_date" value="{{old('joined_date') ?? $employees->joined_date}}" required>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label class="mr-2" for="marital_status">Employment Status</label>
										<span class="badge badge-danger">Required</span>
										<select class="form-control required select2" name="employment_status" required>
											<option value="regular">Regular</option>
											<option value="co-terminus">Co-Terminus</option>
											<option value="probationary">Probationary</option>
											<option value="fixed-term">Fixed-Term</option>
										</select>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label class="mr-2" for="termination_date">Termination Date </label>
										<div class="input">
											<input class="form-control required" type="date" name="termination_date" value="{{old('termination_date') ?? $employees->termination_date}}">
										</div>
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
										<span class="badge badge-danger">Required</span>
										<div class="input">
											<p class="placeholder">Address</p>
											<input class="form-control required" type="text" name="home_address" value="{{old('home_address') ?? $employees->home_address}}" required>
										</div>
									</div>
									<div class="form-group">
										<label class="mr-2" for="email">Email </label>
										<span class="badge badge-danger">Required</span>
										<div class="input">
											<p class="placeholder">Email</p>
											<input class="form-control required" type="email" name="private_email" value="{{old('private_email') ?? $employees->private_email}}" required>
										</div>
									</div>
									<div class="form-group">
										<label class="mr-2" for="email">Bank Account Number </label>
										<span class="badge badge-danger">Required</span>
										<div class="input">
											<p class="placeholder">Bank Account Number</p>
											<input class="form-control required" type="text" name="bank_acc" value="{{old('bank_acc') ?? $employees->bank_acc}}" required>
										</div>
									</div>
									<div class="form-group">
										<label class="mr-2" for="home_work_distance">Km Home-Work </label>
										<div class="input">
											<p class="placeholder">Kilometer Home - Work</p>
											<input class="form-control required" type="number" name="home_distance" value="{{old('home_distance') ?? $employees->home_distance}}">
										</div>
									</div>
									<div class="form-group">
										<h3>Marital Status</h3>
									</div>
									<div class="form-group">
										<label class="mr-2" for="marital_status">Marital Status </label>
										<span class="badge badge-danger">Required</span>
										<select class="form-control required select2" name="marital_status" required>
											<option disabled default selected>---select one---</option>
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
										<span class="badge badge-danger">Required</span>
										<div class="input">
											<p class="placeholder">Emergeny Contact</p>
											<input class="form-control required" type="text" name="emergency_contact" value="{{old('emergency_contact') ?? $employees->emergency_contact}}" required>
										</div>
									</div>
									<div class="form-group">
										<label class="mr-2" for="emergency_phone">Emergency Phone</label>
										<span class="badge badge-danger">Required</span>
										<div class="input">
											<p class="placeholder">Emergeny Phone</p>
											<input class="form-control required" type="text" name="emergency_no" value="{{old('emergency_no') ?? $employees->emergency_no}}" required>
										</div>
									</div>
									<div class="form-group">
										<h3>Education</h3>
									</div>
									<div class="form-group">
										<label class="mr-2" for="marital_status">Certificate Level </label>
										<span class="badge badge-danger">Required</span>
										<select class="form-control required select2" name="cert_level" required>
											<option disabled default selected>---select one---</option>
											<option value="bachelor">bachelor</option>
											<option value="master">Master</option>
											<option value="doctoral">Doctoral</option>
										</select>
									</div>
									<div class="form-group">
										<label class="mr-2" for="field_study">Field of Study</label>
										<span class="badge badge-danger">Required</span>
										<div class="input">
											<p class="placeholder">Field of Study</p>
											<input class="form-control required" type="text" name="field_study" value="{{old('field_study') ?? $employees->field_study}}" required>
										</div>
									</div>
									<div class="form-group">
										<label class="mr-2" for="school">School</label>
										<span class="badge badge-danger">Required</span>
										<div class="input">
											<p class="placeholder">School</p>
											<input class="form-control required" type="text" name="school" value="{{old('school') ?? $employees->school}}" required>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<h3>Citizenship</h3>
									</div>
									<div class="form-group">
										<label class="mr-2" for="nationality">Nationality </label>
										<span class="badge badge-danger">Required</span>
										<select class="form-control required select2" name="nationality">
											<option disabled default selected>-- select one --</option>
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
										<label class="mr-2" for="passport_no">Passport No. </label>
										<div class="input">
											<p class="placeholder">Passport No.</p>
											<input class="form-control required" type="text" name="passport_no" value="{{old('passport_no') ?? $employees->passport_no}}">
										</div>
									</div>
									<div class="form-group">
										<label class="mr-2" for="gender">Gender </label>
										<span class="badge badge-danger">Required</span>
										<select class="form-control required select2" name="gender" required>
											<option value="male">Male</option>
											<option value="female">Female</option>
										</select>
									</div>
									<div class="form-group">
										<label class="mr-2" for="birthday">Date of Birth </label>
										<span class="badge badge-danger">Required</span>
										<div class="input">
											<input class="form-control required" type="date" name="birthday" value="{{old('birthday') ?? $employees->birthday}}" required>
										</div>
									</div>
									<div class="form-group">
										<label class="mr-2" for="place_birth">Place of Birth </label>
										<span class="badge badge-danger">Required</span>
										<div class="input">
											<p class="placeholder">Place of Birth</p>
											<input class="form-control required" type="text" name="place_birth" value="{{old('place_birth') ?? $employees->place_birth}}" required>
										</div>
									</div>
									<div class="form-group">
										<h3>Dependant</h3>
									</div>
									<div class="form-group">
										<label class="mr-2" for="dependant">Number of Children</label>
										<div class="input">
											<p class="placeholder">Number of Children</p>
											<input class="form-control required" type="number" name="dependant" min="0" value="{{old('dependant') ?? $employees->dependant}}">
										</div>
									</div>
									<div class="form-group">
										<h3>Work Permit</h3>
									</div>
									<div class="form-group">
										<label class="mr-2" for="visa">Visa No.</label>
										<div class="input">
											<p class="placeholder">Visa No.</p>
											<input class="form-control required" type="number" name="visa_no" value="{{old('visa_no') ?? $employees->visa_no}}">
										</div>
									</div>
									<div class="form-group">
										<label class="mr-2" for="work_permit">Work Permit No.</label>
										<div class="input">
											<p class="placeholder">Work Permit No.</p>
											<input class="form-control required" type="number" name="work_permit" value="{{old('work_permit') ?? $employees->work_permit}}">
										</div>
									</div>
									<div class="form-group">
										<label class="mr-2" for="visa_expire">Visa Expiry Date</label>
										<div class="input">
											<p class="placeholder">Visa Expire Date</p>
											<input class="form-control required" type="date" name="visa_expire" value="{{old('visa_expire') ?? $employees->visa_expire}}">
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
		</form>
	</div>
	<div class="card-footer text-right">
		<a class="btn btn-default mr-1" href="/hris/pages/employees/employee/index"><i class="fa fa-arrow-left"></i> back</a>
		<button class="btn btn-success" type="submit" form="form"><i class="fa fa-upload"></i> save employee record</button>
	</div>
</div>
@stop
@section('css')
<link rel="stylesheet" href="{{ URL::asset('assets/css/admin_custom.css') }}">
@stop
@section('js')
<script src="{{ URL::asset('assets/js/main.js') }}"></script>
<script>
	//preview image
	var loadFile = function(event) {
		var output = document.getElementById('image-preview');
		output.src = URL.createObjectURL(event.target.files[0]);
		output.onload = function() {
			URL.revokeObjectURL(output.src) // free memory
		}
	};
</script>
@stop