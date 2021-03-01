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
        if ( $_SESSION['sys_role_ids'] == ',1,' ) {
            $workshift_assignment = hris_workshift_assignment::where('del_status', 0)->orderBy('id', 'DESC')->get();
            return view('pages.time.workshiftAssignment.index', compact('workshift_assignment', 'hr_officer_id', 'sys_role_ids'));
        } else {
            // CHECK IF SUPERVISOR OR NOT
            // IF SUPERVISOR AND HR OFFICER
            if ( in_array($supervisor_id, $sys_role_ids) OR in_array($hr_officer_id, $sys_role_ids) ) {
                if (in_array($hr_officer_id, $sys_role_ids)) {
                    $subordinate = hris_employee::all()->where('del_status', 0);
                    foreach ($subordinate as $s) {
                        $subordinate_id[] = $s->id;
                    }
                } else {
                    $subordinate = hris_employee::where('supervisor', $_SESSION['sys_id'])->where('del_status', 0)->get('id');
                    foreach ($subordinate as $s) {
                        $subordinate_id[] = $s->id;
                    }
                }
                $self = hris_workshift_assignment::where('del_status', 0)->where('employee_id', $_SESSION['sys_id'])->orderBy('id', 'DESC')->get();
                $workshift_assignment = hris_workshift_assignment::where('del_status', 0)->whereIn('employee_id', $subordinate_id)->orderBy('id', 'DESC')->get();
                return view('pages.time.workshiftAssignment.index', compact('workshift_assignment', 'self','supervisor_id','sys_role_ids','hr_officer_id'));
            } else {
                //IF EMPLOYEE
                $workshift_assignment = hris_workshift_assignment::where('del_status', 0)->where('employee_id', $_SESSION['sys_id'])->orderBy('id', 'DESC')->get();
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
        if ( $_SESSION['sys_role_ids'] == ',1,') {
            $employees = hris_employee::where('del_status', 0)->where('supervisor', '!=', '')->whereNotNull('supervisor')->get();
            $work_shift = hris_work_shift_management::all()->where('del_status', 0);
            return view('pages.time.workshiftAssignment.create', compact('workshift_assignment', 'employees', 'work_shift'));
        } else {
            // IF NOT SUPERADMIN CHECK IF SUPERVISOR OR NOT
            // IF SUPERVISOR
            if ( in_array($supervisor_id, $sys_role_ids) OR in_array($hr_officer_id, $sys_role_ids) ) {
                $sys_id = hris_employee::find($_SESSION['sys_id']);
                if ( $sys_id->supervisor != NULL ) {
                    $employees_id[] = $_SESSION['sys_id'];
                }
                if ( in_array($hr_officer_id, $sys_role_ids) ) {
                    $subordinates = hris_employee::where('del_status', 0)->where('supervisor', '!=', '')->whereNotNull('supervisor')->get();
                    foreach ($subordinates as $s) {
                        $employees_id[] = $s->id;
                    }
                } else {
                    $subordinates = hris_employee::where('del_status', 0)->where('supervisor', $_SESSION['sys_id'])->get();
                    foreach ($subordinates as $s) {
                        $employees_id[] = $s->id;
                    }
                }
                $employees = hris_employee::where('del_status', 0)->whereIn('id', $employees_id)->get();
                $work_shift = hris_work_shift_management::all()->where('del_status', 0);
                return view('pages.time.workshiftAssignment.create', compact('workshift_assignment', 'employees', 'work_shift'));

            } else {
                // IF EMPLOYEE
                $employees = hris_employee::where('del_status', 0)->where('id', $_SESSION['sys_id'])->get();
                $work_shift = hris_work_shift_management::all()->where('del_status', 0);
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
        $date_approve = date("Y-m-d");
        if ($this->validatedData()) {
            $data = [];
            $employee_ids = $request->employee_id;
            foreach($employee_ids as $employee_id){
                $current_workshift = false;
                $e = hris_employee::find($employee_id);
                if ( $e->supervisor != NULL ) {
                    if ($_SESSION['sys_role_ids'] == ',1,' OR in_array($hr_officer_id, $sys_role_ids) OR in_array($supervisor_id, $sys_role_ids)) {
                        $current_workshift = hris_workshift_assignment::where('employee_id', $employee_id)->where('current', 1)->first();

                        if ($_SESSION['sys_id'] == $e->id) {
                            $insert_data = ['employee_id'=>$employee_id, 'workshift_id'=>$request->workshift_id, 'date_from'=>date('Ymd', strtotime($request->date_from)),'date_to'=>date('Ymd', strtotime($request->date_to)),'status'=>0,'current'=>1,'date_approve'=>$date_approve];
                            array_push($data,$insert_data);
                            if ( $_SESSION['sys_role_ids'] == ',1,' ) {
                                // WORKSHIFT NOTIFICATION
                                $sender = users::find($_SESSION['sys_id']);
                                $employee_receiver = hris_employee::find($e->id);
                                $employee_receiver->notify(new WorkShiftNotif($sender));
                            } else {
                                // WORKSHIFT NOTIFICATION
                                $sender = hris_employee::find($_SESSION['sys_id']);
                                $employee_receiver = hris_employee::find($e->id);
                                $employee_receiver->notify(new WorkShiftNotif($sender));
                            }
                        } else {
                            $insert_data = ['employee_id'=>$employee_id, 'workshift_id'=>$request->workshift_id, 'date_from'=>date('Ymd', strtotime($request->date_from)),'date_to'=>date('Ymd', strtotime($request->date_to)),'status'=>1, 'current' =>1, 'date_approve' => $date_approve];
                            array_push($data,$insert_data);
                            if ( $_SESSION['sys_role_ids'] == ',1,' ) {
                                // WORKSHIFT NOTIFICATION
                                $sender = users::find($_SESSION['sys_id']);
                                $employee_receiver = hris_employee::find($e->id);
                                $employee_receiver->notify(new WorkShiftNotif($sender));
                            } else {
                                // WORKSHIFT NOTIFICATION
                                $sender = hris_employee::find($_SESSION['sys_id']);
                                $employee_receiver = hris_employee::find($e->id);
                                $employee_receiver->notify(new WorkShiftNotif($sender));
                            }
                        }

                    } else {
                        $insert_data = ['employee_id'=>$employee_id, 'workshift_id'=>$request->workshift_id, 'date_from'=>date('Ymd', strtotime($request->date_from)),'date_to'=>date('Ymd', strtotime($request->date_to)),'status'=> 0, 'current' => 2];
                        array_push($data,$insert_data);
                        // WORKSHIFT NOTIFICATION
                        $sender = hris_employee::find($_SESSION['sys_id']);
                        $employee_receiver = hris_employee::find($e->supervisor);
                        $employee_receiver->notify(new WorkShiftNotif($sender));

                    }

                }
            }
            if ( $data != NULL ) {
                if($current_workshift){
                    $current_workshift->current = 0;
                    $current_workshift->update();
                }

                $workshift_assignment = hris_workshift_assignment::insert($data);
                return redirect('/hris/pages/time/workshiftAssignment/index')->with('success', 'Work Shift successfully assigned!');
            } else {
                return back()->withErrors(['Employee supervisor is required.']);
            }
                
        } else {
            return back()->withErrors($this->validatedData());
        }
        
    }
    public function edit(hris_workshift_assignment $workshift_assignment, hris_employee $employees, hris_work_shift_management $work_shift){
        if ( $workshift_assignment->employee->supervisor != NULL ) {
            $hr_officer_role_id = roles::where('role_name', 'hr officer')->get('id')->toArray();
            $hr_officer_id = implode(' ', $hr_officer_role_id[0]);
            $supervisor_role_id = roles::where('role_name', 'supervisor')->get('id')->toArray();
            $supervisor_id = implode(' ', $supervisor_role_id[0]);
            $sys_role_ids = explode(',', $_SESSION['sys_role_ids']);
            // CHECK IF SUPERADMIN OR NOT
            // IF SUPERADMIN
            if ( $_SESSION['sys_role_ids'] == ',1,') {
                $employees = hris_employee::where('del_status', 0)->where('supervisor', '!=', '')->whereNotNull('supervisor')->get();
                $work_shift = hris_work_shift_management::all()->where('del_status', 0);
                return view('pages.time.workshiftAssignment.edit', compact('workshift_assignment', 'employees', 'work_shift'));
            } else {
                // IF NOT SUPERADMIN CHECK IF SUPERVISOR OR NOT
                // IF SUPERVISOR
                if ( in_array($supervisor_id, $sys_role_ids) OR in_array($hr_officer_id, $sys_role_ids) ) {
                    $sys_id = hris_employee::find($_SESSION['sys_id']);
                    if ( $sys_id->supervisor != NULL ) {
                        $employees_id[] = $_SESSION['sys_id'];
                    }
                    if ( in_array($hr_officer_id, $sys_role_ids) ) {
                        $subordinates = hris_employee::where('del_status', 0)->where('supervisor', '!=', '')->whereNotNull('supervisor')->get();
                        foreach ($subordinates as $s) {
                            $employees_id[] = $s->id;
                        }
                    } else {
                        $subordinates = hris_employee::where('del_status', 0)->where('supervisor', $_SESSION['sys_id'])->get();
                        foreach ($subordinates as $s) {
                            $employees_id[] = $s->id;
                        }
                    }
                    $employees = hris_employee::where('del_status', 0)->whereIn('id', $employees_id)->get();
                    $work_shift = hris_work_shift_management::all()->where('del_status', 0);
                    return view('pages.time.workshiftAssignment.edit', compact('workshift_assignment', 'employees', 'work_shift'));

                } else {
                    // IF EMPLOYEE
                    $employees = hris_employee::where('del_status', 0)->where('id', $_SESSION['sys_id'])->get();
                    $work_shift = hris_work_shift_management::all()->where('del_status', 0);
                    return view('pages.time.workshiftAssignment.edit', compact('workshift_assignment', 'employees', 'work_shift'));
                }
            }
        } else {
            return back()->withErrors(['Employee supervisor is required.']);
        }
        /*
        $employees = hris_employee::all();
        $employee = hris_employee::with('getEmployeeWorkShiftAssignmentRelation')->first();
        $work_shift = hris_work_shift_management::all();
        $workshift_rel = hris_work_shift_management::with('getWorkShiftAssignmentRelation')->first();
        return view('pages.time.workshiftAssignment.edit', compact('workshift_assignment','employee','workshift_rel','employees', 'work_shift'));
        */
    }
    public function update(Request $request, hris_workshift_assignment $workshift_assignment){
        $id = $workshift_assignment->id;
        if ($this->validatedData()) {
            $string = 'App\hris_workshift_assignment';
            $workshift_assignment->employee_id = $request->employee_id;
            $workshift_assignment->workshift_id = $request->workshift_id;
            $workshift_assignment->date_from = date('Ymd', strtotime($request->date_from));
            $workshift_assignment->date_to = date('Ymd', strtotime($request->date_to));
            $workshift_assignment->current = 0;
            $workshift_assignment->date_approve = date("Y-m-d");

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
        $superadmin_role_id = roles::where('role_name', 'super admin')->get('id')->toArray();
        $superadmin_id = implode(' ', $superadmin_role_id[0]);
        // SUPERVISOR ROLE ID
        $hr_officer_role_id = roles::where('role_name', 'hr officer')->get('id')->toArray();
        $hr_officer_id = implode(' ', $hr_officer_role_id[0]);
        // SUPERVISOR ROLE ID
        $supervisor_role_id = roles::where('role_name', 'supervisor')->get('id')->toArray();
        $supervisor_id = implode(' ', $supervisor_role_id[0]);
        // SUPERADMIN HR OFFICER AND SUPERVISOR ROLE ID ARRAY
        $access_roles = array($superadmin_id,$hr_officer_id,$supervisor_id);
        $sys_role_ids = explode(',', $_SESSION['sys_role_ids']);

        if ( $workshift_assignment->employee->supervisor != NULL ) {
            if ( array_intersect($sys_role_ids, $access_roles) ) {
                if ( $_SESSION['sys_role_ids'] == ',1,' ) {
                    $workshift_assignment->status = $status;
                    // get current ws
                    $current_workshift = hris_workshift_assignment::where('employee_id', $workshift_assignment->employee_id)->where('current', 1)->first();
                    if ( $status == 1 ) {
                        // change current ws to old
                        if ($current_workshift) {
                            $current_workshift->current = 0;
                            $current_workshift->update();
                        }
                        
                        $workshift_assignment->current = 1;
                        $workshift_assignment->date_approve = date("Y-m-d");
                        
                        $msg = 'Work shift approved.';
                    } else {
                        $msg = 'Work shift denied.';
                    }

                    $workshift_assignment->update();
                    return redirect('/hris/pages/time/workshiftAssignment/index')->with('success', $msg);
                } else {
                    if ( $workshift_assignment->employee_id == $_SESSION['sys_id'] ) {
                        return back()->withErrors(['You do not have access in this page.']);
                    } else {
                        // get current ws
                        $current_workshift = hris_workshift_assignment::where('employee_id', $workshift_assignment->employee_id)->where('current', 1)->first();
                        $workshift_assignment->status = $status;
                        $workshift_assignment->current = 1;
                        $workshift_assignment->date_approve = date("Y-m-d");
                        if ( $status == 1 ) {
                            $workshift_assignment->current = 1;
                            $workshift_assignment->date_approve = date("Y-m-d");
                            // change current ws to old
                            if ($current_workshift) {
                                $current_workshift->current = 0;
                                $current_workshift->update();
                            }
                            $msg = 'Work shift approved.';
                        } else {
                            $msg = 'Work shift denied.';
                        }
                        $workshift_assignment->update();
                        return redirect('/hris/pages/time/workshiftAssignment/index')->with('success', $msg);
                    }
                }
            } else {
                return back()->withErrors(['You do not have access in this page.']);
            }
        } else {
            return back()->withErrors(['Employee supervisor is required.']);
        }
    }
    public function destroy(hris_workshift_assignment $workshift_assignment)
    {
        $id = $_SESSION['sys_id'];
        if ( $_SESSION['sys_role_ids'] == ',1,' ) {
            $upass = $this->function->decryptStr(users::find($id)->upass);
            if ( $upass == request('upass') ) {
                $workshift_assignment->del_status = 1;
                $workshift_assignment->update();
                $id = $workshift_assignment->id;
                $this->function->deleteSystemLog($this->module, $id);
                return redirect('/hris/pages/time/workshiftAssignment/index')->with('success', 'Work Shift successfully deleted!');
            } else {
                return back()->withErrors(['Password does not match.']);
            }
        } else {
            $employee = hris_employee::find($id);
            if ( Hash::check(request('upass'), $employee->password) ) {
                $workshift_assignment->del_status = 1;
                $workshift_assignment->update();
                $id = $workshift_assignment->id;
                $this->function->deleteSystemLog($this->module, $id);
                return redirect('/hris/pages/time/workshiftAssignment/index')->with('success', 'Work Shift successfully deleted!');
            } else {
                return back()->withErrors(['Password does not match.']);
            }
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
