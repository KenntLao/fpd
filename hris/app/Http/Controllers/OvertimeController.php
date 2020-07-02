<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\hris_overtime;
use App\hris_employee;
use App\roles;
use App\users;
use App\Notifications\SupervisorNotif;

class OvertimeController extends Controller
{
    private $function;
    private $module;

    public function __construct() {
        $this->function = new FunctionController;
        $this->module = 'Time Management - Overtime';
    }
    public function index(hris_overtime $overtimes)
    {
        $id = $_SESSION['sys_id'];
        if ($_SESSION['sys_role_ids'] == ',1,' ) {
            $overtimes = hris_overtime::paginate(10);
            return view('pages.time.overtime.index', compact('overtimes'));
        } else {
            $roles = roles::all();
            $supervisor_role_id = roles::where('role_name', 'supervisor')->get('id')->toArray();
            $supervisor_id = implode(' ', $supervisor_role_id[0]);
            $find = hris_employee::find($id);
            $role_ids = explode(',', $find->role_id);

            if ( in_array($supervisor_id, $role_ids) ) {
                $department = $find->department_id;
                $employee = hris_employee::all()->where('department_id', $department)->where('supervisor', $id);
                $employee_id = array();
                foreach ($employee as $e) {
                    $employee_id[] = $e->id;
                }
                $overtimes = hris_overtime::whereIn('employee_id', $employee_id)->paginate(10);
                $self = hris_overtime::where('employee_id', $_SESSION['sys_id'])->paginate(10);
                return view('pages.time.overtime.index', compact('overtimes','role_ids', 'supervisor_id', 'self'));
            } else {
                $overtimes = hris_overtime::where('employee_id', $id)->paginate(10);
                return view('pages.time.overtime.index', compact('overtimes','role_ids', 'supervisor_id'));
            }

        }
    }
    public function create(hris_overtime $overtime)
    {
        $id = $_SESSION['sys_id'];
        $employee = hris_employee::find($id);
        return view('pages.time.overtime.create', compact('overtime', 'id', 'employee'));
    }
    public function store(hris_overtime $overtime,Request $request)
    {
        $id = $_SESSION['sys_id'];
        $employee = hris_employee::find($id);
        if ( $employee->supervisor == NULL ) {
            return back()->withErrors(['Employee supervisor is required']);
        } else {
            if ( $this->validatedData() ) {
                $overtime->employee_id = $id;
                $overtime->ot_date = request('ot_date');
                $overtime->ot_time_in = request('ot_time_in');
                $overtime->ot_time_out = request('ot_time_out');
                $overtime->employee_remarks = request('employee_remarks');
                $overtime->supervisor_remarks = request('supervisor_remarks');
                $overtime->supervisor_id = request('supervisor_id');
                $overtime->approved_date = request('approved_date');
                $overtime->status = '0';
                $overtime->save();

                // OVERTIME REQUEST NOTIFICATION
                $employee = hris_employee::find($_SESSION['sys_id']);
                $get_supervisor = hris_employee::where('id', $_SESSION['sys_id'])->get('supervisor');
                $employee_supervisor = hris_employee::find($get_supervisor)->first();
                $employee_supervisor->notify(new SupervisorNotif($employee));

                /* SYSTEM LOG */
                $id = $overtime->id;
                $this->function->addSystemLog($this->module,$id);
                
                return redirect('/hris/pages/time/overtime/index')->with('success', 'Overtime request successfully added!');
            } else {
                return back()->withErrors($this->validatedData());
            }
        }
    }
    public function show(hris_overtime $overtime)
    {   
        $id = $_SESSION['sys_id'];
        if( $overtime->role_id == ',1,' ) {
            $users = users::find($overtime->supervisor_id);
            $user = $users->uname;
        } else {
            $user = $overtime->supervisor->firstname.' '.$overtime->supervisor->lastname;
        }
        return view('pages.time.overtime.show', compact('overtime', 'user'));
    }
    public function edit(hris_overtime $overtime)
    {
        $id = $_SESSION['sys_id'];
        $employee_id = $overtime->employee_id;
        $employee = hris_employee::find($employee_id);
        $roles = roles::all();
        $supervisor_role_id = roles::where('role_name', 'supervisor')->get('id')->toArray();
        $supervisor_id = implode(' ', $supervisor_role_id[0]);
        $employee_supervisor = hris_employee::all()->where('role_id', ','.$supervisor_id.',')->where('department_id', $employee->department_id);
        if ( $id == $employee->supervisor ) {
            return redirect()->back();
        } else {
            return view('pages.time.overtime.edit', compact('overtime', 'id', 'employee', 'employee_supervisor'));
        }

    }
    public function editStatus($status, hris_overtime $overtime)
    {
        $id = $_SESSION['sys_id'];
        $employee_id = $overtime->employee_id;
        $employee = hris_employee::find($employee_id);
        $roles = roles::all();
        $supervisor_role_id = roles::where('role_name', 'supervisor')->get('id')->toArray();
        $supervisor_id = implode(' ', $supervisor_role_id[0]);
        $employee_supervisor = hris_employee::all()->where('role_id', ','.$supervisor_id.',')->where('department_id', $employee->department_id);
        if ( $id == $employee_id ) {
            return redirect()->back();
        } else {
            return view('pages.time.overtime.edit', compact('overtime', 'id', 'employee', 'employee_supervisor', 'status'));
        }

    }
    public function update(hris_overtime $overtime, Request $request)
    {
        $id = $overtime->id;
        $string = 'App\hris_overtime';
        if ($this->validatedData()) {
            $overtime->ot_date = request('ot_date');
            $overtime->ot_time_in = request('ot_time_in');
            $overtime->ot_time_out = request('ot_time_out');
            $overtime->employee_remarks = request('employee_remarks');
            // GET CHANGES
            $changes = $overtime->getDirty();
            // GET ORIGINAL DATA
            $this->function->getOldData($this->module,$string,$changes,$id);
            $overtime->update();
            // GET CHANGES
            $changed = $overtime->getChanges();
            // USE UPDATESYSTEMLOG FUNCTION
            $this->function->updateSystemLog($this->module,$changed,$string,$id);
            if ( $overtime->wasChanged() ) {
                return redirect('/hris/pages/time/overtime/index')->with('success', 'Overtime request successfully updated!');
            } else {
                return redirect('/hris/pages/time/overtime/index');
            }
        } else {
            return back()->withErrors($this->validatedData());
        }
    }
    public function updateStatus($status, hris_overtime $overtime, Request $request)
    {
        $id = $_SESSION['sys_id'];
        $string = 'App\hris_overtime';
        $employee_id = $overtime->employee_id;
        $employee = hris_employee::find($employee_id);
        $roles = roles::all();
        $supervisor_role_id = roles::where('role_name', 'supervisor')->get('id')->toArray();
        $supervisor_id = implode(' ', $supervisor_role_id[0]);
        $employee_supervisor = hris_employee::all()->where('role_id', ','.$supervisor_id.',')->where('department_id', $employee->department_id);
        $es_id = array();
        foreach ($employee_supervisor as $es) {
            $es_id[] = $es->id;
        }
        if ( $_SESSION['sys_role_ids'] == ',1,' ) {
            $id = $overtime->id;
            if ($this->supervisorData()) {
                $model = $overtime;
                $this->function->statusSystemLog($this->module,$string,$id);
                if( $status == 1 OR $status == 2 ) {
                    if( $status == 1 ) {
                        $msg = 'approved';
                    }
                    if ( $status == 2 ) {
                        $msg = 'denied';
                    }
                    $overtime->status = $status;
                } else {
                    return redirect('/hris/pages/time/overtime/index')->withErrors(['Invalid status.']);
                }
                $overtime->supervisor_id = $_SESSION['sys_id'];
                $overtime->role_id = $_SESSION['sys_role_ids'];
                $overtime->approved_date = date('Y-m-d H:i:s');
                $overtime->type = request('type');
                $overtime->supervisor_remarks = request('supervisor_remarks');
                $overtime->update();
                return redirect('/hris/pages/time/overtime/index')->with('success', 'Overtime request '.$msg.'!');
            } else {
                return back()->withErrors($this->supervisorData());
            }
        } else {
            if (in_array($id, $es_id)) {
                $id = $overtime->id;
                if ($this->supervisorData()) {
                    $this->function->statusSystemLog($this->module,$string,$id);
                    if( $status == 1 OR $status == 2 ) {
                        if( $status == 1 ) {
                            $msg = 'approved';
                        }
                        if ( $status == 2 ) {
                            $msg = 'denied';
                        }
                        $overtime->status = $status;
                    } else {
                        return redirect('/hris/pages/time/overtime/index')->withErrors(['Invalid status.']);
                    }
                    $overtime->supervisor_id = $_SESSION['sys_id'];
                    $overtime->role_id = $_SESSION['sys_role_ids'];
                    $overtime->approved_date = date('Y-m-d H:i:s');
                    $overtime->type = request('type');
                    $overtime->supervisor_remarks = request('supervisor_remarks');
                    $overtime->update();
                    return redirect('/hris/pages/time/overtime/index')->with('success', 'Overtime request '.$msg.'!');
                } else {
                    return back()->withErrors($this->supervisorData());
                } 
            }
        }
    }

    public function destroy(hris_overtime $overtime)
    {
        $id = $_SESSION['sys_id'];
        if ( $_SESSION['sys_role_ids'] == ',1,' ) {
            $upass = $this->function->decryptStr(users::find($id)->upass);
            if ( $upass == request('upass') ) {
                $overtime->delete();
                $id = $overtime->id;
                $this->function->deleteSystemLog($this->module,$id);
                return redirect('/hris/pages/time/overtime/index')->with('success','Overtime request successfully deleted!');
            } else {
                return back()->withErrors(['Password does not match.']);
            }
        } else {
            $employee = hris_employee::find($id);
            if ( Hash::check(request('upass'), $employee->password) ) {
                $overtime->delete();
                $id = $overtime->id;
                $this->function->deleteSystemLog($this->module,$id);
                return redirect('/hris/pages/time/overtime/index')->with('success', 'Overtime request successfully deleted!');
            } else {
                return back()->withErrors(['Password does not match.']);
            }
        }
    }
    protected function validatedData()
    {
        return request()->validate([
            'ot_date' => 'required',
            'ot_time_in' => 'required|date_format:H:i',
        	'ot_time_out' => 'required|date_format:H:i|after:ot_time_in',
        	'employee_remarks' => 'required',
            'type' => 'nullable',
            'supervisor_remarks' => 'nullable',
            'supervisor_id' => 'nullable',
            'role_id' => 'nullable',
            'approved_date' => 'nullable',
            'status' => 'nullable',
        ]);
    }
    protected function supervisorData()
    {
        return request()->validate([
            'ot_date' => 'required',
            'ot_time_in' => 'required|date_format:H:i',
            'ot_time_out' => 'required|date_format:H:i|after:ot_time_in',
            'employee_remarks' => 'required',
            'type' => 'required',
            'supervisor_remarks' => 'required',
            'supervisor_id' => 'nullable',
            'role_id' => 'nullable',
            'approved_date' => 'nullable',
            'status' => 'nullable',
        ]);
    }
}
