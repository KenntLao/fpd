<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        $action = 'add';
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
                $this->function->systemLog($this->module,$action,$id);
                
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
        return view('pages.time.overtime.edit', compact('overtime', 'id', 'employee', 'employee_supervisor'));

    }
    public function update(hris_overtime $overtime, Request $request)
    {
        $id = $_SESSION['sys_id'];
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
                //DO systemLog function FROM SystemLogController
                $this->function->updateSystemLog($model,$this->module,$id);
                if ( request('status') == '1' OR request('status') == '2' ) {
                    if ( request('status') == '1' ) {
                        $status = 'accepted';
                    }
                    if ( request('status') == '2' ) {
                        $status = 'rejected';
                    }
                    $overtime->status = request('status');
                } else {
                    return redirect('/hris/pages/time/overtime/index')->withErrors(['Invalid status.']);
                }
                $overtime->supervisor_id = $_SESSION['sys_id'];
                $overtime->role_id = $_SESSION['sys_role_ids'];
                $overtime->approved_date = date('Y-m-d H:i:s');
                $overtime->type = request('type');
                $overtime->supervisor_remarks = request('supervisor_remarks');
                $overtime->update();
                return redirect('/hris/pages/time/overtime/index')->with('success', 'Overtime request '.$status.'!');
            } else {
                return back()->withErrors($this->supervisorData());
            }
        } else {
            if (in_array($id, $es_id)) {
                $id = $overtime->id;
                if ($this->supervisorData()) {
                    $model = $overtime;
                    //DO systemLog function FROM SystemLogController
                    $this->function->updateSystemLog($model,$this->module,$id);
                    if ( request('status') == '1' OR request('status') == '2' ) {
                        if ( request('status') == '1' ) {
                            $status = 'accepted';
                        }
                        if ( request('status') == '2' ) {
                            $status = 'rejected';
                        }
                        $overtime->status = request('status');
                    } else {
                        return redirect('/hris/pages/time/overtime/index')->withErrors(['Invalid status.']);
                    }
                    $overtime->supervisor_id = $_SESSION['sys_id'];
                    $overtime->role_id = $_SESSION['sys_role_ids'];
                    $overtime->approved_date = date('Y-m-d H:i:s');
                $overtime->type = request('type');
                    $overtime->supervisor_remarks = request('supervisor_remarks');
                    $overtime->update();
                    return redirect('/hris/pages/time/overtime/index')->with('success', 'Overtime request '.$status.'!');
                } else {
                    return back()->withErrors($this->supervisorData());
                } 
            } else {
                $id = $overtime->id;
                if ($this->validatedData()) {
                    $model = $overtime;
                    //DO systemLog function FROM SystemLogController
                    $this->function->updateSystemLog($model,$this->module,$id);
                    $overtime->ot_date = request('ot_date');
                    $overtime->ot_time_in = request('ot_time_in');
                    $overtime->ot_time_out = request('ot_time_out');
                    $overtime->employee_remarks = request('employee_remarks');
                    $overtime->update();
                    return redirect('/hris/pages/time/overtime/index')->with('success', 'Overtime request successfully updated!');
                } else {
                    return back()->withErrors($this->validatedData());
                }
            }
        }
    }

    public function destroy(hris_overtime $overtime)
    {
        $action = 'delete';
        $id = $_SESSION['sys_id'];
        if ( $_SESSION['sys_role_ids'] == ',1,' ) {
            $upass = $this->function->decryptStr(users::find($id)->upass);
            if ( $upass == request('upass') ) {
                $overtime->delete();
                $id = $overtime->id;
                $this->function->systemLog($this->module,$action,$id);
                return redirect('/hris/pages/time/overtime/index')->with('success','Overtime request successfully deleted!');
            } else {
                return back()->withErrors(['Password does not match.']);
            }
        } else {
            $employee = hris_employee::find($id);
            if ( Hash::check(request('upass'), $employee->password) ) {
                $overtime->delete();
                $id = $overtime->id;
                $this->function->systemLog($this->module,$action,$id);
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
