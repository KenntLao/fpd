<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\hris_employee;
use App\users;
use App\hris_job_titles;
use App\roles;
use App\hris_company_structures;
use App\hris_employment_statuses;
use App\hris_certifications;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\EmployeeImport;
use App\Exports\EmployeeExport;
use App\hris_pay_grades;
use Faker\Generator as Faker;



class EmployeeController extends Controller
{
    
//
    public function index(hris_employee $employee){
        $role_id = trim(str_replace(',','',$_SESSION['sys_role_ids']));
        $sys_id = $_SESSION['sys_id'];
        $acc_mode = $_SESSION['sys_account_mode'];
        if(isset($_SESSION['sys_dep_id'])){ // if employee have department
            $sys_dep_id = $_SESSION['sys_dep_id'];
            if ($sys_dep_id && $sys_id && $acc_mode == "employee") { // get all subordinate
                $employees = hris_employee::where('department_id', $sys_dep_id)->where('id', '!=', $sys_id)->where('supervisor', $sys_id)->paginate(10);
            } else {
                $employees = hris_employee::paginate(10);
            }
        }else {
            $employees = hris_employee::paginate(10);
        }
        return view('pages.employees.employee.index', compact('employee','employees','role_id'));
    }
    public function create(hris_employee $employee, roles $roles, hris_company_structures $deparments, hris_job_titles $job_titles)
    {
        $certifications = hris_certifications::all();
        $employment_statuses = hris_employment_statuses::all();
        $roles = roles::all();
        $job_titles = hris_job_titles::all();
        $departments = hris_company_structures::all();
        $pay_grades = hris_pay_grades::all();
        $role_ids = explode(',', $employee->role_id);
        return view('pages.employees.employee.create', compact('employee','roles', 'departments','job_titles','role_ids', 'employment_statuses','certifications','pay_grades'));
    }

    public function store(Request $request, hris_employee $employees, Faker $faker) {
        if($this->validatedData()){
            // check data if valid
            $path = public_path('assets/images/employees/employee_photos/');
            if ($request->hasFile('employee_photo')) {
                $imageName = time() . 'EP.' . $request->employee_photo->extension();
                $request->employee_photo->move($path, $imageName);
            } else { // if image is empty create faker
                if ($request->gender == 'male') {
                    $imageName = $faker->file($path . '/male/tmp', $path, false);
                } else {
                    $imageName = $faker->file($path . '/female/tmp', $path, false);
                }
            }
            // CREATE USERNAME
            $employee_firstname = request('firstname');
            if(request('middlename')){
                $employee_middlename = request('middlename');
            }else {
                $employee_middlename = '';
            }
            $employee_lastname = request('lastname');
            $employee_number = request('employee_number');
            $username = substr($employee_firstname,0,1).substr($employee_middlename, 0, 1).substr($employee_lastname, 0, 1).$employee_number;
            $password = Hash::make(1234);

            if (request('role') == NULL) {
                $role_ids = ',8,';
            } else {
                $role_ids = implode(',', request('role'));
            }

            $employees->employee_photo = $imageName;
            $employees->employee_number = request('employee_number');
            $employees->username = $username;
            $employees->password = $password;
            $employees->firstname = request('firstname');
            $employees->middlename = request('middlename');
            $employees->lastname = request('lastname');
            $employees->role_id = ','.$role_ids.',';
            $employees->work_no = request('work_no');
            $employees->work_phone = request('work_phone');
            $employees->work_email = request('work_email');
            $employees->department_id = request('department');
            $employees->job_title_id = request('job_title');
            $employees->supervisor = request('supervisor');
            $employees->work_address = request('work_address');
            $employees->tin = request('tin');
            $employees->sss = request('sss');
            $employees->pagibig = request('pagibig');
            $employees->phic = request('phic');
            $employees->joined_date = request('joined_date');
            $employees->employment_status = request('employment_status');
            $employees->termination_date = request('termination_date');
            $employees->home_address = request('home_address');
            $employees->private_email = request('private_email');
            $employees->home_distance = request('home_distance');
            $employees->marital_status = request('marital_status');
            $employees->emergency_contact = request('emergency_contact');
            $employees->emergency_no = request('emergency_no');
            $employees->cert_level = request('cert_level');
            $employees->field_study = request('field_study');
            $employees->school = request('school');
            $employees->gender = request('gender');
            $employees->nationality = request('nationality');
            $employees->birthday = request('birthday');
            $employees->place_birth = request('place_birth');
            $employees->dependant = request('dependant');
            $employees->pay_grade = request('pay_grade');
            $employees->save();
            return redirect('/hris/pages/employees/employee/index')->with('success', 'Employee successfully added!');   
        }else { // if data fails
                return back()->withErrors($this->validatedData());
        }
    }

    public function edit(hris_employee $employee, roles $roles, hris_company_structures $deparments, hris_job_titles $job_titles){
            $certifications = hris_certifications::all();
            $employment_statuses = hris_employment_statuses::all();
            $job_titles = hris_job_titles::all();
            $roles = roles::all();
            $departments = hris_company_structures::all();
            $role_ids = explode(',',$employee->role_id);
            $supervisor = hris_employee::where('id',$employee->supervisor)->first();
            $pay_grades = hris_pay_grades::all();
            return view('pages.employees.employee.edit', compact('employee', 'roles', 'departments','job_titles','role_ids','supervisor','employment_statuses', 'certifications','pay_grades'));
    }

    public function update(Request $request, hris_employee $employee, Faker $faker){
        if ($this->validatedData()) {
            // check data if valid
            $path = public_path('assets/images/employees/employee_photos/');
            // REMOVE OLD FILE
            /*if ($employee->employee_photo != '' && $employee->employee_photo != NULL) {
                $old_file = $path . $employee->employee_photo;
                unlink($old_file);
            } */
            if ($request->hasFile('employee_photo')) {
                $imageName = time() . 'EP.' . $request->employee_photo->extension();
                $request->employee_photo->move($path, $imageName);
            } else { // if image is empty create faker
                if ($request->gender == 'male') {
                    $imageName = $faker->file($path . '/male/tmp', $path, false);
                } else {
                    $imageName = $faker->file($path . '/female/tmp', $path, false);
                }
            }
            
            // CREATE USERNAME
            $employee_firstname = request('firstname');
            if (request('middlename')) {
                $employee_middlename = request('middlename');
            } else {
                $employee_middlename = '';
            }
            $employee_lastname = request('lastname');
            $employee_number = request('employee_number');
            $username = substr($employee_firstname, 0, 1) . substr($employee_middlename, 0, 1) . substr($employee_lastname, 0, 1) . $employee_number;
            $password = Hash::make(1234);
            if (request('role') == NULL) {
                $role_ids = ',8,';
            } else {
                $role_ids = implode(',', request('role'));
            }

            $employee->employee_photo = $imageName;
            $employee->employee_number = request('employee_number');
            $employee->username = $username;
            $employee->password = $password;
            $employee->firstname = request('firstname');
            $employee->middlename = request('middlename');
            $employee->lastname = request('lastname');
            $employee->role_id = ','.$role_ids.',';
            $employee->work_no = request('work_no');
            $employee->work_phone = request('work_phone');
            $employee->work_email = request('work_email');
            $employee->department_id = request('department');
            $employee->job_title_id = request('job_title');
            $employee->supervisor = request('supervisor');
            $employee->work_address = request('work_address');
            $employee->tin = request('tin');
            $employee->sss = request('sss');
            $employee->pagibig = request('pagibig');
            $employee->phic = request('phic');
            $employee->joined_date = request('joined_date');
            $employee->employment_status = request('employment_status');
            $employee->termination_date = request('termination_date');
            $employee->home_address = request('home_address');
            $employee->private_email = request('private_email');
            $employee->home_distance = request('home_distance');
            $employee->marital_status = request('marital_status');
            $employee->emergency_contact = request('emergency_contact');
            $employee->emergency_no = request('emergency_no');
            $employee->cert_level = request('cert_level');
            $employee->field_study = request('field_study');
            $employee->school = request('school');
            $employee->gender = request('gender');
            $employee->nationality = request('nationality');
            $employee->birthday = request('birthday');
            $employee->place_birth = request('place_birth');
            $employee->dependant = request('dependant');
            $employee->pay_grade = request('pay_grade');
            $employee->update();
            return redirect($_SESSION['return_page'])->with('success', 'Employee successfully updated!');
        } else { // if data fails
            return back()->withErrors($this->validatedData());
        }
    }

    public function show(hris_employee $employee) {
        
        $supervisor = hris_employee::where('id',$employee->supervisor)->first();
        return view('pages.employees.employee.show',compact('employee','supervisor'));
    }

    public function destroy(hris_employee $employee)
    {
        $id = $_SESSION['sys_id'];
        $upass = $this->decryptStr(users::find($id)->upass);
        if ($upass == request('upass')) {
            $employee->delete();
            return redirect('/hris/pages/employees/employee/index')->with('success', 'Employee successfully deleted!');
        } else {
            return back()->withErrors(['Password does not match.']);
        }
    }
    
    // decrypt string
    function decryptStr($str)
    {
        $key = '4507';
        $c = base64_decode($str);
        $ivlen = openssl_cipher_iv_length($cipher = "AES-128-CBC");
        $iv = substr($c, 0, $ivlen);
        $hmac = substr($c, $ivlen, $sha2len = 32);
        $ciphertext_raw = substr($c, $ivlen + $sha2len);
        $original_plaintext = openssl_decrypt($ciphertext_raw, $cipher, $key, $options = OPENSSL_RAW_DATA, $iv);
        $calcmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary = true);
        if (hash_equals($hmac, $calcmac)) {
            return $original_plaintext;
        }
    }

    public function getSupervisorRoleId()
    {
        $supervisor_role_id = roles::where('role_name', 'supervisor')->get('id')->toArray();
        return implode(' ', $supervisor_role_id[0]);
    }
    public function getEmployeeSupervisors()
    {
        return hris_employee::whereRaw('find_in_set(?,role_id)', [$this->getSupervisorRoleId()])->get('id')->toArray();
    }
    public function renderSupervisor(Request $request){
        $department_id = $request->get('department_id');
        $supervisors = hris_employee::whereRaw('find_in_set(?,role_id)', [$this->getSupervisorRoleId()])->where('department_id',$department_id)->get();
        $output = '<option value="">-- select one --</option>';
        foreach ($supervisors as $supervisor) {
            $output .= '<option value="' . $supervisor->id . '">' . $supervisor->firstname . ' '. $supervisor->lastname .'</option>';
        }
        echo $output;
    }

    // EXCEL IMPORT EXPORT
    public function import(){
        if($this->validateImport()){
            Excel::import(new EmployeeImport, request()->file('employeeData'));
            return redirect('/hris/pages/employees/employee/index')->with('success', 'Employee list successfully uploaded!');
        } else {
            return back()->withErrors($this->validateImport());
        }
    }
    public function export()
    {
        return Excel::download(new EmployeeExport, 'employee_data.xlsx');
    }
    public function table(hris_employee $employee)
    {
        $employees = hris_employee::all();
        $job_title = hris_job_titles::where('id', $employee->job_title_id)->first();
        return view('pages.employees.employee.table', compact('employees','job_title'));
    }

    protected function validateImport(){
        return request()->validate([
            'employeeData' => 'required|mimes:xlsx',
        ]);
    }
    // FORM VALIDATION
    protected function validatedData()
    {
        return request()->validate([
            'employee_photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'employee_number' => 'nullable',
            'firstname' => 'nullable',
            'middlename' => 'nullable',
            'lastname' => 'nullable',
            'job_title' => 'nullable',
            'work_no' => 'nullable',
            'work_phone' => 'nullable',
            'work_email' => 'email',
            'department' => 'nullable',
            'supervisor' => 'nullable',
            'work_address' => 'nullable',
            'tin' => 'nullable',
            'sss' => 'nullable',
            'pagibig' => 'nullable',
            'phic' => 'nullable',
            'joined_date' => 'nullable|date',
            'employment_status' => 'nullable',
            'termination_date' => 'nullable|date',
            'home_address' => 'nullable',
            'private_email' => 'nullable|email',
            'home_distance' => 'nullable',
            'marital_status' => 'nullable',
            'emergency_contact' => 'nullable',
            'emergency_no' => 'nullable',
            'cert_level' => 'nullable',
            'field_study' => 'nullable',
            'school' => 'nullable',
            'gender' => 'nullable',
            'nationality' => 'nullable',
            'birthday' => 'nullable|date',
            'place_birth' => 'nullable',
            'dependant' => 'nullable',
        ]);
    }
}
