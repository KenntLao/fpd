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
        /* GET HR OFFICER ROLE ID */
        $hr_ids = roles::where('role_name', 'HR Officer')->get('id')->toArray();
        $hr_id = implode(' ', $hr_ids[0]);

        /* GET CURRET USER ROLE ID */
        if($acc_mode == "employee") {
            $current_user_level = hris_employee::where('id', $sys_id)->get('role_id')->toArray();
            $user_level = implode(' ', $current_user_level[0]);
            $user_level_arr = explode(',', $user_level);
        }


        if(isset($_SESSION['sys_dep_id'])){ // if employee have department
            $sys_dep_id = $_SESSION['sys_dep_id'];
            if ($sys_dep_id && $sys_id && $acc_mode == "employee") { // get all subordinate
                if (in_array($hr_id, $user_level_arr)) {
                    $employees = hris_employee::get();
                } else {
                    $employees = hris_employee::where('department_id', $sys_dep_id)->where('id', '!=', $sys_id)->where('supervisor', $sys_id)->get();
                }
            } else {
                $employees = hris_employee::get();
            }
        }else {
            $employees = hris_employee::get();
        }
        return view('pages.employees.employee.index', compact('employee','employees','role_id'));
    }

    public function create(hris_employee $employee, roles $roles, hris_company_structures $deparments, hris_job_titles $job_titles)
    {
        $certifications = hris_certifications::where('del_status', 0)->get();
        $employment_statuses = hris_employment_statuses::where('del_status', 0)->get();
        $roles = roles::all();
        $job_titles = hris_job_titles::where('del_status', 0)->get();
        $departments = hris_company_structures::where('del_status', 0)->get();
        $pay_grades = hris_pay_grades::where('del_status', 0)->get();
        $role_ids = explode(',', $employee->role_id);
        return view('pages.employees.employee.create', compact('employee','roles', 'departments','job_titles','role_ids', 'employment_statuses','certifications','pay_grades'));
    }

    public function store(Request $request, hris_employee $employees, Faker $faker) {
        if($this->validatedData()){
            $exist = 0;
            if($employees::where('employee_number',$request->employee_number)->first()) {
                $exist = 1;
            }
            // check data if valid
            if($exist == 0){
                // sanitize data function
                $sanitized_data = $this->sanitizeData($this->validatedData());

                $path = public_path('assets/images/employees/employee_photos/');
                if ( $request->hasFile('employee_photo') ) {
                    $imageName = $sanitized_data['employee_photo'];
                    $request->employee_photo->move($path, $sanitized_data['employee_photo']);
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
                    $role_ids = ','.implode(',', request('role')) . ',';
                }

                
                // END
                $sanitized_data += ['username' => $username, 'password' => $password, 'del_status' => 0, 'employee_photo' =>$imageName, 'role_id' => $role_ids];

                
                foreach($sanitized_data as $key => $data) {
                    if($data == "") {
                        unset($sanitized_data[$key]);
                    }
                }
                $employees::create($sanitized_data);
                
                return redirect('/hris/pages/employees/employee/index')->with('success', 'Employee successfully added!');
            } else {
                return back()->with('error', 'Employee already exist!');
            }
        }else { // if data fails
                return back()->withErrors($this->validatedData());
        }
    }

    public function edit(hris_employee $employee, roles $roles, hris_company_structures $deparments, hris_job_titles $job_titles){
            $certifications = hris_certifications::where('del_status', 0)->get();
            $employment_statuses = hris_employment_statuses::where('del_status', 0)->get();
            $job_titles = hris_job_titles::where('del_status', 0)->get();
            $roles = roles::all();
            $departments = hris_company_structures::where('del_status', 0)->get();
            $role_ids = explode(',',$employee->role_id);
            $supervisor = hris_employee::where('id',$employee->supervisor)->first();
            $pay_grades = hris_pay_grades::all();
            return view('pages.employees.employee.edit', compact('employee', 'roles', 'departments','job_titles','role_ids','supervisor','employment_statuses', 'certifications','pay_grades'));
    }

    public function update(Request $request, hris_employee $employee, Faker $faker){
        if ($this->validatedData()) {
            // check data if valid
            $exist = 0;
            if ($employee::where('employee_number', $request->employee_number)->where('id','!=',$employee->id)->first()) {
                $exist = 1;
            }
            // check data if valid
            if ($exist == 0) {

                // sanitize data function
                $sanitized_data = $this->sanitizeData($this->validatedData());

                foreach($sanitized_data as $key => $data) {
                    if($data == "") {
                        unset($sanitized_data[$key]);
                    }
                }

                $path = public_path('assets/images/employees/employee_photos/');

                if ( $request->hasFile('employee_photo') ) {
                    // REMOVE ALL FILE
                    if ($employee->employee_photo != '' && $employee->employee_photo != NULL) {
                        $old_file = $path . $employee->employee_photo;
                        unlink($old_file);
                    } 
                    $imageName = $sanitized_data['employee_photo'];
                    $request->employee_photo->move($path, $sanitized_data['employee_photo']);

                } else { // if image is empty create faker
                    if ($employee->employee_photo == '' && $employee->employee_photo == NULL) {
                        if ($request->gender == 'male') {
                            $imageName = $faker->file($path . '/male/tmp', $path, false);
                        } else {
                            $imageName = $faker->file($path . '/female/tmp', $path, false);
                        }
                    } 
                }

                $fill = $employee->fill($sanitized_data);
                
                if($employee->isDirty('firstname') OR $employee->isDirty('middlename') OR $employee->isDirty('lastname') OR $employee->isDirty('employee_number')) {
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
                    $employee->username = $username;
                }

                if (request('role') == NULL) {
                    $role_ids = ',8,';
                } else {
                    $role_ids = ','.implode(',', request('role')) . ',';
                }

                $employee->role_id = $role_ids;

                $employee->save();

                return redirect($_SESSION['return_page'])->with('success', 'Employee successfully updated!');
            } else {
                return redirect('/hris/pages/employees/employee/'.$employee->id.'/edit')->with('error', 'Employee already exist!');
            }
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
        if ( $_SESSION['sys_account_mode'] == 'user' ) {
            $upass = $this->function->decryptStr(users::find($id)->upass);
            if ( $upass == request('upass') ) {
                $employee->del_status = 1;
                $employee->update();
                $id = $employee->id;
                $this->function->deleteSystemLog($this->module,$id);
                return redirect('/hris/pages/employees/employee/index')->with('success', 'Employee successfully deleted!');
            } else {
                return back()->withErrors(['Password does not match.']);
            }

        } else {
            $employee = hris_employee::find($id);
            if ( Hash::check(request('password'), $employee->password) ) {
                $employee->del_status = 1;
                $employee->update();
                $id = $employee->id;
                $this->function->deleteSystemLog($this->module,$id);            
                return redirect('/hris/pages/employees/employee/index')->with('success', 'Employee successfully deleted!');
            } else {
                return back()->withErrors(['Password does not match.']);
            }
        }
    }

    public function getSupervisorRoleId()
    {
        $supervisor_role_id = roles::where('role_name', 'supervisor')->get('id')->toArray();
        return implode(' ', $supervisor_role_id[0]);
    }

    public function getHRmanager(){
        $manager_role_id = roles::where('role_name', 'hr manager')->get('id')->toArray();
        return implode(' ', $manager_role_id[0]);
    }

    public function getDirector(){
        $director_role_id = roles::where('role_name', 'director')->get('id')->toArray();
        return implode(' ', $director_role_id[0]);
    }

    public function getEmployeeSupervisors()
    {
        return hris_employee::whereRaw('find_in_set(?,role_id)', [$this->getSupervisorRoleId()])->get('id')->toArray();
    }
    public function renderSupervisor(Request $request){
        $department_id = $request->get('department_id');
        $hr_manager = hris_employee::whereRaw('find_in_set(?,role_id)', [$this->getHRmanager()])->first();
        $supervisors = hris_employee::whereRaw('find_in_set(?,role_id)', [$this->getSupervisorRoleId()])->where('department_id',$department_id)->get();
        $directors = hris_employee::whereRaw('find_in_set(?,role_id)', [$this->getDirector()])->get();


        $output = '<option value="">-- select one --</option>';
        $output .= '<option value="' . $hr_manager->id . '">' . $hr_manager->firstname . ' ' . $hr_manager->lastname . '</option>';

        foreach ($directors as $director) {
            $output .= '<option value="' . $director->id . '">' . $director->firstname . ' ' . $director->lastname . '</option>';
        }

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

    public function sanitizeData($validatedData)
    {
        foreach ($validatedData as $key => $data) {
            if ( is_array($data) ) {
                $new_data[] = strip_tags(implode(',', $data));
            } else {
                if ( $key == 'employee_photo' ) {
                    $new_data[] = time().'IMG.'.$validatedData['employee_photo']->getClientOriginalExtension();
                } else {
                    if ( $data == NULL ) {
                        $new_data[] = '';
                    } else {
                        $new_data[] = strip_tags($data);
                    }
                }
            }
            $keys[] = $key;
        }
        $arr = array_combine($keys, $new_data);
        return $arr;
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
            'employee_number' => 'required',
            'firstname' => 'required',
            'middlename' => 'nullable',
            'lastname' => 'required',
            'job_title_id' => 'required',
            'work_no' => 'required',
            'work_phone' => 'nullable',
            'work_email' => 'nullable|email',
            'department_id' => 'required',
            'supervisor' => 'required',
            'work_address' => 'nullable',
            'tin' => 'nullable',
            'sss' => 'nullable',
            'pagibig' => 'nullable',
            'phic' => 'nullable',
            'joined_date' => 'nullable|date',
            'employment_status' => 'required',
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
            'employee_type' => 'required',
            'employee_agency' => 'nullable'
        ]);
    }
}
