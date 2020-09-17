<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\hris_workshift_assignment;
use App\hris_work_shift_management;
use App\hris_employee;
use App\users;
use App\roles;
use App\Notifications\WorkShiftNotif;

class WorkShiftAssignmentController extends Controller
{
    private $function;
    private $module;

    public function __construct() {
        $this->function = new FunctionController;
        $this->module = 'Time Management - Work Shift Assignment';
    }

    public function index(hris_workshift_assignment $workshift_assignment)
    {
        $hr_officer_role_id = roles::where('role_name', 'hr officer')->get('id')->toArray();
        $hr_officer_id = implode(' ', $hr_officer_role_id[0]);
        $supervisor_role_id = roles::where('role_name', 'supervisor')->get('id')->toArray();
        $supervisor_id = implode(' ', $supervisor_role_id[0]);
        $sys_role_ids = explode(',', $_SESSION['sys_role_ids']);
        // CHECK IF SUPERADMIN OR NOT
        // IF SUPERADMIN
        if ( $_SESSION['sys_role_ids'] == ',1,' OR in_array($hr_officer_id, $sys_role_ids) ) {
            $workshift_assignment = hris_workshift_assignment::paginate(10);
            return view('pages.time.workshiftAssignment.index', compact('workshift_assignment', 'hr_officer_id', 'sys_role_ids'));
        } else {
            // CHECK IF SUPERVISOR OR NOT
            // IF SUPERVISOR
            if ( in_array($supervisor_id, $sys_role_ids) ) {
                $subordinate = hris_employee::where('supervisor', $_SESSION['sys_id'])->get('id');
                foreach ($subordinate as $s) {
                    $subordinate_id[] = $s->id;
                }
                $self = hris_workshift_assignment::where('employee_id', $_SESSION['sys_id'])->paginate(10);
                $workshift_assignment = hris_workshift_assignment::whereIn('employee_id', $subordinate_id)->paginate(10);
                return view('pages.time.workshiftAssignment.index', compact('workshift_assignment', 'self','supervisor_id','sys_role_ids','hr_officer_id'));
            } else {
                //IF EMPLOYEE
                $workshift_assignment = hris_workshift_assignment::where('employee_id', $_SESSION['sys_id'])->paginate(10);
                return view('pages.time.workshiftAssignment.index', compact('workshift_assignment','supervisor_id', 'sys_role_ids','hr_officer_id'));
            }
        }
    }
    public function create(hris_workshift_assignment $workshift_assignment, hris_employee $employees, hris_work_shift_management $work_shift)
    {
        $hr_officer_role_id = roles::where('role_name', 'hr officer')->get('id')->toArray();
        $hr_officer_id = implode(' ', $hr_officer_role_id[0]);
        $supervisor_role_id = roles::where('role_name', 'supervisor')->get('id')->toArray();
        $supervisor_id = implode(' ', $supervisor_role_id[0]);
        $sys_role_ids = explode(',', $_SESSION['sys_role_ids']);
        // CHECK IF SUPERADMIN OR NOT
        // IF SUPERADMIN
        if ( $_SESSION['sys_role_ids'] == ',1,' OR in_array($hr_officer_id, $sys_role_ids) ) {
            $employees = hris_employee::all();
            $work_shift = hris_work_shift_management::all();
            return view('pages.time.workshiftAssignment.create', compact('workshift_assignment', 'employees', 'work_shift'));
        } else {
            // IF NOT SUPERADMIN CHECK IF SUPERVISOR OR NOT
            // IF SUPERVISOR
            if ( in_array($supervisor_id, $sys_role_ids) ) {
                $employees_id[] = $_SESSION['sys_id'];
                $subordinates = hris_employee::where('supervisor', $_SESSION['sys_id'])->get();
                foreach ($subordinates as $s) {
                    $employees_id[] = $s->id;
                }
                $employees = hris_employee::whereIn('id', $employees_id)->get();
                $work_shift = hris_work_shift_management::all();
                return view('pages.time.workshiftAssignment.create', compact('workshift_assignment', 'employees', 'work_shift'));

            } else {
                // IF EMPLOYEE
                $employees = hris_employee::where('id', $_SESSION['sys_id'])->get();
                $work_shift = hris_work_shift_management::all();
                return view('pages.time.workshiftAssignment.create', compact('workshift_assignment', 'employees', 'work_shift'));
            }
        }
        
    }
    public function store(Request $request, hris_workshift_assignment $workshift_assignment)
    {
        $hr_officer_role_id = roles::where('role_name', 'hr officer')->get('id')->toArray();
        $hr_officer_id = implode(' ', $hr_officer_role_id[0]);
        $supervisor_role_id = roles::where('role_name', 'supervisor')->get('id')->toArray();
        $supervisor_id = implode(' ', $supervisor_role_id[0]);
        $sys_role_ids = explode(',', $_SESSION['sys_role_ids']);
        // CHECK IF SUPERADMIN OR NOT
        // IF SUPERADMIN
        if ( $_SESSION['sys_role_ids'] == ',1,' OR in_array($hr_officer_id, $sys_role_ids) ) {
            $employee = hris_employee::find($request->employee_id);
            // IF EMPLOYEE HAS SUPERVISOR
            if ( $employee->supervisor != NULL ) {
                if ($this->validatedData()) {
                    $workshift_assignment->employee_id = $request->employee_id;
                    $workshift_assignment->workshift_id = $request->workshift_id;
                    $workshift_assignment->date_from = date('Ymd', strtotime($request->date_from));
                    $workshift_assignment->date_to = date('Ymd', strtotime($request->date_to));
                    $workshift_assignment->status = 0;
                    $workshift_assignment->save();

                    // WORKSHIFT NOTIFICATION
                    $employee_req = $request->employee_id;
                    if ( in_array($hr_officer_id, $sys_role_ids) ) {
                        $employee = hris_employee::find($_SESSION['sys_id']);
                    } else {
                        $employee = users::find($_SESSION['sys_id']);
                    }
                    $employee_receiver = hris_employee::find($employee_req);
                    $employee_receiver->notify(new WorkShiftNotif($employee));

                    return redirect('/hris/pages/time/workshiftAssignment/index')->with('success', 'Work Shift successfully assigned!');
                } else {
                    return back()->withErrors($this->validatedData());
                }
            } else {
                // IF EMPLOYEE HAS NO SUPERVISOR
                return back()->withErrrors(['Employee supervisor is required.']);
            }
        } else {
            // IF NOT SUPERADMIN
            $employee = hris_employee::find($_SESSION['sys_id']);
            // CHECK IF SUPERVISOR OR NOT
            // IF SUPERVISOR
            if ( in_array($supervisor_id, $sys_role_ids) ) {
                if ($this->validatedData()) {
                    // IF REQUEST IS FOR HIMSELF/HERSELF
                    if ( $request->employee_id == $_SESSION['sys_id'] ) {
                        // CHECK IF SUPERVISOR HAS SUPERVISOR
                        if ( $employee->supervisor != NULL ) {
                            $workshift_assignment->employee_id = $request->employee_id;
                            $workshift_assignment->workshift_id = $request->workshift_id;
                            $workshift_assignment->date_from = date('Ymd', strtotime($request->date_from));
                            $workshift_assignment->date_to = date('Ymd', strtotime($request->date_to));
                            $workshift_assignment->status = 0;
                            $workshift_assignment->save();

                            // WORKSHIFT NOTIFICATION
                            $sender = hris_employee::find($_SESSION['sys_id']);
                            $employee_receiver = hris_employee::find($employee->supervisor);
                            $employee_receiver->notify(new WorkShiftNotif($sender));
                            return redirect('/hris/pages/time/workshiftAssignment/index')->with('success', 'Work Shift successfully assigned!');
                        } else {
                            return back()->withErrrors(['Employee supervisor is required.']);
                        }
                    } else {
                        // IF REQUEST IS FOR SUBORDINATES
                        $workshift_assignment->employee_id = $request->employee_id;
                        $workshift_assignment->workshift_id = $request->workshift_id;
                        $workshift_assignment->date_from = date('Ymd', strtotime($request->date_from));
                        $workshift_assignment->date_to = date('Ymd', strtotime($request->date_to));
                        $workshift_assignment->status = 1;
                        $workshift_assignment->save();

                        // WORKSHIFT NOTIFICATION
                        $sender = hris_employee::find($_SESSION['sys_id']);
                        $employee_receiver = hris_employee::find($request->employee_id);
                        $employee_receiver->notify(new WorkShiftNotif($sender));
                        return redirect('/hris/pages/time/workshiftAssignment/index')->with('success', 'Work Shift successfully assigned!');
                    }
                } else {
                    return back()->withError($this->validatedData());
                }
            } else {
                // IF NOT SUPERVISOR
                // EMPLOYEE REQUEST
                if ($this->validatedData()) {
                    $workshift_assignment->employee_id = $request->employee_id;
                    $workshift_assignment->workshift_id = $request->workshift_id;
                    $workshift_assignment->date_from = date('Ymd', strtotime($request->date_from));
                    $workshift_assignment->date_to = date('Ymd', strtotime($request->date_to));
                    $workshift_assignment->status = 0;
                    $workshift_assignment->save();

                    // WORKSHIFT NOTIFICATION
                    $sender = hris_employee::find($_SESSION['sys_id']);
                    $employee_receiver = hris_employee::find($employee->supervisor);
                    $employee_receiver->notify(new WorkShiftNotif($sender));
                    return redirect('/hris/pages/time/workshiftAssignment/index')->with('success', 'Work Shift successfully assigned!');
                } else {
                    return back()->withError($this->validatedData());
                }
            }
        }
    }
    public function edit(hris_workshift_assignment $workshift_assignment, hris_employee $employees, hris_work_shift_management $work_shift){
        $employees = hris_employee::all();
        $employee = hris_employee::with('getEmployeeWorkShiftAssignmentRelation')->first();
        $work_shift = hris_work_shift_management::all();
        $workshift_rel = hris_work_shift_management::with('getWorkShiftAssignmentRelation')->first();
        return view('pages.time.workshiftAssignment.edit', compact('workshift_assignment','employee','workshift_rel','employees', 'work_shift'));
    }
    public function update(Request $request, hris_workshift_assignment $workshift_assignment){
        $id = $workshift_assignment->id;
        if ($this->validatedData()) {
            $string = 'App\hris_workshift_assignment';
            $workshift_assignment->employee_id = $request->employee_id;
            $workshift_assignment->workshift_id = $request->workshift_id;
            $workshift_assignment->date_from = date('Ymd', strtotime($request->date_from));
            $workshift_assignment->date_to = date('Ymd', strtotime($request->date_to));

            //DO systemLog function FROM SystemLogController
            // GET CHANGES
            $changes = $workshift_assignment->getDirty();
            // GET ORIGINAL DATA
            $this->function->getOldData($this->module, $string, $changes, $id);
            $workshift_assignment->update();
            // GET CHANGES
            $changed = $workshift_assignment->getChanges();
            // USE UPDATESYSTEMLOG FUNCTION
            $this->function->updateSystemLog($this->module, $changed, $string, $id);
            if ($workshift_assignment->wasChanged()) {
                return redirect('/hris/pages/time/workshiftAssignment/index')->with('success', 'Work Shift successfully assigned!');
            } else {
                return redirect('/hris/pages/time/workshiftAssignment/index');
            }
            
        } else {
            return back()->withErrors($this->validatedData());
        }
    }
    public function status(hris_workshift_assignment $workshift_assignment, $status) 
    {
        // SUPERVISOR ROLE ID
        $hr_officer_role_id = roles::where('role_name', 'hr officer')->get('id')->toArray();
        $hr_officer_id = implode(' ', $hr_officer_role_id[0]);
        // SUPERVISOR ROLE ID
        $supervisor_role_id = roles::where('role_name', 'supervisor')->get('id')->toArray();
        $supervisor_id = implode(' ', $supervisor_role_id[0]);
        // SUPERADMIN HR OFFICER AND SUPERVISOR ROLE ID ARRAY
        $access_roles = array('1',$hr_officer_id,$supervisor_id);
        $sys_role_ids = explode(',', $_SESSION['sys_role_ids']);

        if ( array_intersect($sys_role_ids, $access_roles) ) {
            if ( $workshift_assignment->employee_id == $_SESSION['sys_id'] ) {
                return back()->withErrors(['You do not have access in this page.']);
            } else {
                $workshift_assignment->status = $status;
                $workshift_assignment->update();
                if ( $status == 1 ) {
                    $msg = 'Work shift approved.';
                } else {
                    $msg = 'Work shift denied.';
                }
                return redirect('/hris/pages/time/workshiftAssignment/index')->with('success', $msg);
            }
        } else {
            return back()->withErrors(['You do not have access in this page.']);
        }
    }
    public function destroy(hris_workshift_assignment $workshift_assignment)
    {
        $id = $_SESSION['sys_id'];
        $employee = hris_employee::find($id);
        if (Hash::check(request('upass'), $employee->password)) {
            $workshift_assignment->delete();
            $id = $workshift_assignment->id;
            $this->function->deleteSystemLog($this->module, $id);
            return redirect('/hris/pages/time/workshiftAssignment/index')->with('success', 'Work Shift successfully deleted!');
        } else {
            return back()->withErrors(['Password does not match.']);
        }
    }
    
    protected function validatedData()
    {
        return request()->validate([
            'employee_id' => 'required',
            'workshift_id' => 'required',
            'date_from' => 'required',
            'date_to' => 'required',
        ]);
    }
}
