<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\hris_overtime;
use App\hris_overtime_categories;
use App\hris_employee;
use App\roles;
use App\users;
use App\hris_company_structures;
use App\hris_overtime_types;
use App\Notifications\SupervisorNotif;
use App\hris_work_shift_management;
use App\hris_workshift_assignment;

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
        $hr_officer_role_id = roles::where('role_name', 'hr officer')->get('id')->toArray();
        $hr_officer_id = implode(' ', $hr_officer_role_id[0]);
        $supervisor_role_id = roles::where('role_name', 'supervisor')->get('id')->toArray();
        $supervisor_id = implode(' ', $supervisor_role_id[0]);
        $roles = explode(',', $_SESSION['sys_role_ids']);
        $employees = hris_employee::all();
        $types = hris_overtime_types::all();
        if ($_SESSION['sys_role_ids'] == ',1,' OR in_array($hr_officer_id, $roles) ) {
            $overtimes = hris_overtime::latest()->paginate(10);
            $self = hris_overtime::where('employee_id', $id)->latest()->paginate(10);
            return view('pages.time.overtime.index', compact('overtimes', 'employees', 'types', 'hr_officer_id', 'roles', 'supervisor_id', 'self'));
        } else {
            $roles = roles::all();
            $find = hris_employee::find($id);
            $role_ids = explode(',', $find->role_id);

            if ( in_array($supervisor_id, $role_ids) ) {
                $department = $find->department_id;
                $employee = hris_employee::all()->where('supervisor', $id);
                $employee_id = array();
                foreach ($employee as $e) {
                    $employee_id[] = $e->id;
                }
                $overtimes = hris_overtime::whereIn('employee_id', $employee_id)->latest()->paginate(10);
                $self = hris_overtime::where('employee_id', $id)->latest()->paginate(10);
                return view('pages.time.overtime.index', compact('overtimes','role_ids', 'supervisor_id', 'self', 'employees', 'types'));
            } else {
                $overtimes = hris_overtime::where('employee_id', $id)->latest()->paginate(10);
                return view('pages.time.overtime.index', compact('overtimes','role_ids', 'supervisor_id'));
            }

        }
    }
    public function create(hris_overtime $overtime)
    {
        $id = $_SESSION['sys_id'];
        $employee = hris_employee::find($id);
        $categories = hris_overtime_categories::all();
        $types = hris_overtime_types::all();
        $departments = hris_company_structures::all();
        $hr_officer_role_id = roles::where('role_name', 'hr officer')->get('id')->toArray();
        $hr_officer_id = implode(' ', $hr_officer_role_id[0]);
        $roles = explode(',', $_SESSION['sys_role_ids']);
        return view('pages.time.overtime.create', compact('overtime', 'id', 'employee', 'categories', 'types', 'departments', 'roles', 'hr_officer_id'));
    }
    public function store(hris_overtime $overtime, Request $request)
    {
        $id = $_SESSION['sys_id'];
        $time1 = strtotime(request('ot_time_in'));
        $time2 = strtotime(request('ot_time_out'));
        if($time2 < $time1) {
            $time2 += 24 * 60 * 60;
        }
        $hr_officer_role_id = roles::where('role_name', 'hr officer')->get('id')->toArray();
        $hr_officer_id = implode(' ', $hr_officer_role_id[0]);
        $roles = explode(',', $_SESSION['sys_role_ids']);
        $ot_difference = ($time2 - $time1)/3600;
        if ( $_SESSION['sys_role_ids'] == ',1,'  OR in_array($hr_officer_id, $roles) ) {
            $employee = hris_employee::find(request('employee_id'));
            if ( $employee->supervisor == NULL ) {
                return back()->withErrors(['Employee supervisor is required']);
            } else {
                if ( $this->validatedData() ) {
                    $ot_date = strtotime(request('ot_date'));
                    $ot_day = lcfirst(date("l", $ot_date));
                    $date = str_replace("-", "", request('ot_date'));
                    $ot_time_in = str_replace(":", "", request('ot_time_in'));
                    $ot_time_out = str_replace(":", "", request('ot_time_out'));
                    $workshift_a = hris_workshift_assignment::where('employee_id', $employee->id)->where('status', '1')->get();
                    $count = count($workshift_a);
                    if ( $count > 0 ) {
                        foreach($workshift_a as $wa)
                        {
                            $wa_id[] = $wa->id;
                        }
                        $latest_wa_id = max($wa_id);
                        $latest_wa = hris_workshift_assignment::find($latest_wa_id);
                        $workshift_id = $latest_wa->workshift_id;
                        if ( $date >= $latest_wa->date_from && $date <= $latest_wa->date_to ) {
                            $wm = hris_work_shift_management::find($workshift_id);
                            $week = array('monday','tuesday','wednesday','thursday','friday','saturday','sunday');
                            foreach ($week as $day)
                            {
                                if ( $ot_day == $day ) {
                                    $time_in = $day.'_time_in';
                                    $time_out = $day.'_time_out';
                                    if ( $ot_time_in < $wm->$time_in && $ot_time_in < $wm->$time_out OR $ot_time_in > $wm->$time_in && $ot_time_in > $wm->$time_out) {
                                        $overtime->acc_mode = $_SESSION['sys_account_mode'];
                                        $overtime->sender_id = $id;
                                        $overtime->employee_id = request('employee_id');
                                        if ( !$overtime->employee->department ) {
                                            $overtime->department_id = 0;
                                        } else {
                                            $overtime->department_id = $overtime->employee->department->id;
                                        }
                                        $overtime->ot_date = request('ot_date');
                                        $overtime->ot_time_in = str_replace(":", "", request('ot_time_in'));
                                        $overtime->ot_time_out = str_replace(":", "", request('ot_time_out'));
                                        $overtime->ot_difference = $ot_difference;
                                        $overtime->overtime_category_id = request('overtime_category_id');
                                        $overtime->supervisor_id = $overtime->employee->supervisor;
                                        $overtime->employee_remarks = request('employee_remarks');
                                        $overtime->status = '0';
                                        $overtime->save();

                                        // OVERTIME REQUEST NOTIFICATION
                                        $employee = hris_employee::where('id',request('employee_id'))->first();
                                        $get_supervisor = hris_employee::where('id',$employee->id)->get('supervisor');
                                        $employee_supervisor = hris_employee::where('id',$employee->supervisor)->first();
                                        $employee_supervisor->notify(new SupervisorNotif($employee));

                                        /* SYSTEM LOG */
                                        $id = $overtime->id;
                                        $this->function->addSystemLog($this->module,$id);
                                                    
                                        return redirect('/hris/pages/time/overtime/index')->with('success', 'Overtime request successfully added!');
                                    } else {
                                        return back()->withErrors(['Invalid time in and time out.']);
                                    }
                                }
                            }
                        } else {
                            return back()->withErrors(['Invalid overtime date. Please check latest workshift.']);
                        }
                    } else {
                        return back()->withErrors(['Please add workshift.']);
                    }
                } else {
                    return back()->withErrors($this->validatedData());
                }
            }
        } else {

            $employee = hris_employee::find($id);
            if ( $employee->supervisor == NULL ) {
                return back()->withErrors(['Employee supervisor is required']);
            } else {
                if ( $this->validatedData() ) {
                    $ot_date = strtotime(request('ot_date'));
                    $ot_day = lcfirst(date("l", $ot_date));
                    $date = str_replace("-", "", request('ot_date'));
                    $ot_time_in = str_replace(":", "", request('ot_time_in'));
                    $ot_time_out = str_replace(":", "", request('ot_time_out'));
                    $workshift_a = hris_workshift_assignment::where('employee_id', $employee->id)->where('status', '1')->get();
                    $count = count($workshift_a);
                    if ( $count > 0 ) {
                        foreach($workshift_a as $wa)
                        {
                            $wa_id[] = $wa->id;
                        }
                        $latest_wa_id = max($wa_id);
                        $latest_wa = hris_workshift_assignment::find($latest_wa_id);
                        $workshift_id = $latest_wa->workshift_id;
                        if ( $date >= $latest_wa->date_from OR $date <= $latest_wa->date_to ) {
                            $wm = hris_work_shift_management::find($workshift_id);
                            $week = array('monday','tuesday','wednesday','thursday','friday','saturday','sunday');
                            foreach ($week as $day)
                            {
                                if ( $ot_day == $day ) {
                                    $time_in = $day.'_time_in';
                                    $time_out = $day.'_time_out';
                                    if ( $ot_time_in < $wm->$time_in && $ot_time_in < $wm->$time_out ) {
                                        $overtime->acc_mode = $_SESSION['sys_account_mode'];
                                        $overtime->sender_id = $id;
                                        $overtime->employee_id = $id;
                                        if ( !$overtime->employee->department ) {
                                            $overtime->department_id = 0;
                                        } else {
                                            $overtime->department_id = $overtime->employee->department->id;
                                        }
                                        $overtime->ot_date = request('ot_date');
                                        $overtime->ot_time_in = str_replace(":", "", request('ot_time_in'));
                                        $overtime->ot_time_out = str_replace(":", "", request('ot_time_out'));
                                        $overtime->ot_difference = $ot_difference;
                                        $overtime->overtime_category_id = request('overtime_category_id');
                                        $overtime->supervisor_id = $overtime->employee->supervisor;
                                        $overtime->employee_remarks = request('employee_remarks');
                                        $overtime->status = '0';
                                        $overtime->save();

                                        // OVERTIME REQUEST NOTIFICATION
                                        $employee = hris_employee::where('id',$_SESSION['sys_id'])->first();
                                        $get_supervisor = hris_employee::where('id',$_SESSION['sys_id'])->get('supervisor');
                                        $employee_supervisor = hris_employee::where('id',$employee->supervisor)->first();
                                        $employee_supervisor->notify(new SupervisorNotif($employee));

                                        /* SYSTEM LOG */
                                        $id = $overtime->id;
                                        $this->function->addSystemLog($this->module,$id);
                                                        
                                        return redirect('/hris/pages/time/overtime/index')->with('success', 'Overtime request successfully added!');
                                    } else if ($ot_time_in > $wm->$time_in && $ot_time_in > $wm->$time_out) {
                                        $overtime->acc_mode = $_SESSION['sys_account_mode'];
                                        $overtime->sender_id = $id;
                                        $overtime->employee_id = $id;
                                        $overtime->department_id = $overtime->employee->department->id;
                                        $overtime->ot_date = request('ot_date');
                                        $overtime->ot_time_in = str_replace(":", "", request('ot_time_in'));
                                        $overtime->ot_time_out = str_replace(":", "", request('ot_time_out'));
                                        $overtime->ot_difference = $ot_difference;
                                        $overtime->overtime_category_id = request('overtime_category_id');
                                        $overtime->supervisor_id = $overtime->employee->supervisor;
                                        $overtime->employee_remarks = request('employee_remarks');
                                        $overtime->status = '0';
                                        $overtime->save();

                                        // OVERTIME REQUEST NOTIFICATION
                                        $employee = hris_employee::where('id',$_SESSION['sys_id'])->first();
                                        $get_supervisor = hris_employee::where('id',$_SESSION['sys_id'])->get('supervisor');
                                        $employee_supervisor = hris_employee::where('id',$employee->supervisor)->first();
                                        $employee_supervisor->notify(new SupervisorNotif($employee));

                                        /* SYSTEM LOG */
                                        $id = $overtime->id;
                                        $this->function->addSystemLog($this->module,$id);
                                                        
                                        return redirect('/hris/pages/time/overtime/index')->with('success', 'Overtime request successfully added!');
                                    } else {
                                        return back()->withErrors(['Invalid time in and time out.']);
                                    }
                                }
                            }
                        } else {
                            return back()->withErrors(['Invalid overtime date. Please check latest workshift.']);
                        }
                    } else {
                        return back()->withErrors(['Please add workshift.']);
                    }
                } else {
                    return back()->withErrors($this->validatedData());
                }
            }
        }
    }

    
    public function show(hris_overtime $overtime)
    {   
        $id = $_SESSION['sys_id'];
        if( $overtime->role_id == ',1,' ) {
            $users = users::find($overtime->approved_by_id);
            $user = $users->uname;
        } else {
            if ( $overtime->approved_by ) {
                $user = $overtime->approved_by->firstname.' '.$overtime->approved_by->lastname;
            } else {
                $user = '---';
            }
        }
        return view('pages.time.overtime.show', compact('overtime', 'user'));
    }
    public function edit(hris_overtime $overtime)
    {
        if ( $_SESSION['sys_role_ids'] == ',1,' ) {
            $categories = hris_overtime_categories::all();
            $roles = explode(',', $_SESSION['sys_role_ids']);
            $supervisor_role_id = roles::where('role_name', 'supervisor')->get('id')->toArray();
            $supervisor_id = implode(' ', $supervisor_role_id[0]);
            $hr_officer_role_id = roles::where('role_name', 'hr officer')->get('id')->toArray();
            $hr_officer_id = implode(' ', $hr_officer_role_id[0]);
                return view('pages.time.overtime.edit', compact('overtime','categories','hr_officer_id', 'roles'));
        } else {
            $id = $_SESSION['sys_id'];
            $categories = hris_overtime_categories::all();
            $employee_id = $overtime->employee_id;
            $employee = hris_employee::find($id);
            $roles = explode(',', $_SESSION['sys_role_ids']);
            $supervisor_role_id = roles::where('role_name', 'supervisor')->get('id')->toArray();
            $supervisor_id = implode(' ', $supervisor_role_id[0]);
            $hr_officer_role_id = roles::where('role_name', 'hr officer')->get('id')->toArray();
            $hr_officer_id = implode(' ', $hr_officer_role_id[0]);
            if ( $id == $employee->supervisor ) {
                return redirect()->back();
            } else {
                return view('pages.time.overtime.edit', compact('overtime','categories','hr_officer_id', 'roles'));
            }
        }

    }

    public function status($status, hris_overtime $overtime) 
    {
        $types = hris_overtime_types::all();
        return view('pages.time.overtime.status', compact('overtime', 'types', 'status'));
    }

    public function update(hris_overtime $overtime, Request $request)
    {
        $id = $overtime->id;
        $emp_id = $_SESSION['sys_id'];
        $string = 'App\hris_overtime';
        $time1 = strtotime(request('ot_time_in'));
        $time2 = strtotime(request('ot_time_out'));
        if($time2 < $time1) {
            $time2 += 24 * 60 * 60;
        }
        $ot_difference = ($time2 - $time1)/3600;
        if ($this->validatedData()) {
            $employee = hris_employee::find($emp_id);
            $ot_date = strtotime(request('ot_date'));
            $ot_day = lcfirst(date("l", $ot_date));
            $date = str_replace("-", "", request('ot_date'));
            $ot_time_in = str_replace(":", "", request('ot_time_in'));
            $ot_time_out = str_replace(":", "", request('ot_time_out'));
            $workshift_a = hris_workshift_assignment::where('employee_id', $employee->id)->where('status', '1')->get();
            $count = count($workshift_a);
            if ( $count > 0 ) {
                foreach($workshift_a as $wa)
                {
                    $wa_id[] = $wa->id;
                }
                $latest_wa_id = max($wa_id);
                $latest_wa = hris_workshift_assignment::find($latest_wa_id);
                $workshift_id = $latest_wa->workshift_id;
                if ( $date >= $latest_wa->date_from && $date <= $latest_wa->date_to ) {
                    $wm = hris_work_shift_management::find($workshift_id);
                    $week = array('monday','tuesday','wednesday','thursday','friday','saturday','sunday');
                    foreach ($week as $day)
                    {
                        if ( $ot_day == $day ) {
                            $time_in = $day.'_time_in';
                            $time_out = $day.'_time_out';
                            if ( $ot_time_in < $wm->$time_in && $ot_time_in < $wm->$time_out OR $ot_time_in > $wm->$time_in && $ot_time_in > $wm->$time_out) {
                                $overtime->ot_date = date('Ymd', strtotime(request('ot_date')));
                                $overtime->ot_time_in = str_replace(":", "", request('ot_time_in'));
                                $overtime->ot_time_out = str_replace(":", "", request('ot_time_out'));
                                $overtime->ot_difference = $ot_difference;
                                $overtime->overtime_category_id = request('overtime_category_id');
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
                                return back()->withErrors(['Invalid time in and time out.']);
                            }
                        }
                    }
                } else {
                    return back()->withErrors(['Invalid overtime date. Please check latest workshift.']);
                }
            } else {
                return back()->withErrors(['Please add workshift.']);
            }
        } else {
            return back()->withErrors($this->validatedData());
        }
    }
    public function updateStatus($status, hris_overtime $overtime, Request $request)
    {
        $id = $_SESSION['sys_id'];
        $time1 = strtotime($overtime->ot_time_in);
        $time2 = strtotime($overtime->ot_time_out);
        if($time2 < $time1) {
            $time2 += 24 * 60 * 60;
        }
        $ot_difference = ($time2 - $time1)/3600;
        $nightdiff = '2200';
        $string = 'App\hris_overtime';
        $employee_id = $overtime->employee_id;
        $employee = hris_employee::find($id);
        $roles = roles::all();
        $supervisor_role_id = roles::where('role_name', 'supervisor')->get('id')->toArray();
        $supervisor_id = implode(' ', $supervisor_role_id[0]);
        $hr_officer_role_id = roles::where('role_name', 'hr officer')->get('id')->toArray();
        $hr_officer_id = implode(' ', $hr_officer_role_id[0]);
        $sys_roles = explode(',', $_SESSION['sys_role_ids']);
        $es_id = array();
        if ( $_SESSION['sys_role_ids'] != ',1,' ) {
            $department_employee = hris_employee::all()->where('department_id', $employee->department_id);
        } else {
            $department_employee = hris_employee::all();
        }
        foreach ($department_employee as $de) {
            $e_rid = explode(',', $de->role_id);
            if ( in_array($supervisor_id, $e_rid) ) {
                $es_id[] = $de->id;
            }
        }
        if ( $_SESSION['sys_role_ids'] == ',1,' OR in_array($hr_officer_id, $sys_roles) ) {
            $id = $overtime->id;
            if ($this->supervisorData()) {
                if ( $status == 1 or $status == 2 ) {
                    if ( $status == 1) {
                        $msg = 'approved';
                        $type = hris_overtime_types::find($request->type);
                        $category = hris_overtime_categories::find($overtime->overtime_category_id);
                        if ($category->name == 'RELIEVER' or $category->name == 'reliever') {
                            // REGULAR
                            if ( $type->id == 1) {
                                $model = $overtime;
                                $this->function->statusSystemLog($this->module,$string,$id);
                                // NIGHT DIFF
                                if ( $overtime->ot_time_out < '0400' OR $overtime->ot_time_out >= $nightdiff ) {
                                    if ( $overtime->ot_time_in < $nightdiff ) {
                                        // IF NIGHT DIFF IS EQUAL OR LESS THAN 8HRS
                                        if ( $ot_difference <= 8 ) {
                                            // IF OT TIME IN IS GREATER THAN 10PM AND LESS THAN 4AM 
                                            $ot_diff = (strtotime($nightdiff) - $time1)/3600;
                                            $reg = $ot_diff;
                                            $reg_8 = null;
                                            $nd = $ot_difference - $ot_diff;
                                        }
                                        if ( $ot_difference > 8 ) {
                                            if ( $overtime->ot_time_in < $nightdiff ) {
                                                $ot_diff = (strtotime($nightdiff) - $time1)/3600;
                                                if ( $ot_diff > 8 ) {
                                                    $reg = 8;
                                                    $reg_8 = $ot_diff-$reg;
                                                    $nd = $ot_difference - $ot_diff;

                                                } else {
                                                    $reg = $ot_diff;
                                                    $reg_8 = null;
                                                    $nd = $ot_difference - $ot_diff;
                                                }
                                            }
                                        }
                                    }
                                } else {
                                    if ( $ot_difference <= 8 ) {
                                        $reg = $ot_difference;
                                        $reg_8 = null;
                                        $nd = null;
                                    } else {
                                        $reg = 8;
                                        $reg_8 = $ot_difference-$reg;
                                        $nd = null;
                                    }
                                }
                                $overtime->REG = $reg;
                                $overtime->REG_8 = $reg_8;
                                $overtime->REG_ND1 = $nd;
                            }
                            // REST DAY
                            if ( $type->id == 2) {
                                $model = $overtime;
                                $this->function->statusSystemLog($this->module,$string,$id);
                                // NIGHT DIFF
                                if ( $overtime->ot_time_out < '0400' OR $overtime->ot_time_out >= $nightdiff ) {
                                    if ( $overtime->ot_time_in < $nightdiff ) {
                                        // IF NIGHT DIFF IS EQUAL OR LESS THAN 8HRS
                                        if ( $ot_difference <= 8 ) {
                                            // IF OT TIME IN IS GREATER THAN 10PM AND LESS THAN 4AM 
                                            $reg = null;
                                            $reg_8 = null;
                                            $nd = $ot_difference;
                                        }
                                        if ( $ot_difference > 8 ) {
                                            if ( $overtime->ot_time_in < $nightdiff ) {
                                                $ot_diff = (strtotime($nightdiff) - $time1)/3600;
                                                if ( $ot_diff > 8 ) {
                                                    $reg = 8;
                                                    $reg_8 = $ot_diff-$reg;
                                                    $nd = $ot_difference - $ot_diff;

                                                } else {
                                                    $reg = $ot_diff;
                                                    $reg_8 = null;
                                                    $nd = $ot_difference - $ot_diff;
                                                }
                                            }
                                        }
                                    }
                                } else {
                                    if ( $ot_difference <= 8 ) {
                                        $reg = $ot_difference;
                                        $reg_8 = null;
                                        $nd = null;
                                    } else {
                                        $reg = 8;
                                        $reg_8 = $ot_difference-$reg;
                                        $nd = null;
                                    }
                                }
                                $overtime->RST = $reg;
                                $overtime->RST_8 = $reg_8;
                                $overtime->RST_ND1 = $nd;
                            }
                            // LEGAL HOLIDAY
                            if ( $type->id == 3) {
                                $model = $overtime;
                                $this->function->statusSystemLog($this->module,$string,$id);
                                // NIGHT DIFF
                                if ( $overtime->ot_time_out < '0400' OR $overtime->ot_time_out >= $nightdiff ) {
                                    if ( $overtime->ot_time_in < $nightdiff ) {
                                        // IF NIGHT DIFF IS EQUAL OR LESS THAN 8HRS
                                        if ( $ot_difference <= 8 ) {
                                            // IF OT TIME IN IS GREATER THAN 10PM AND LESS THAN 4AM 
                                            $reg = null;
                                            $reg_8 = null;
                                            $nd = $ot_difference;
                                        }
                                        if ( $ot_difference > 8 ) {
                                            if ( $overtime->ot_time_in < $nightdiff ) {
                                                $ot_diff = (strtotime($nightdiff) - $time1)/3600;
                                                if ( $ot_diff > 8 ) {
                                                    $reg = 8;
                                                    $reg_8 = $ot_diff-$reg;
                                                    $nd = $ot_difference - $ot_diff;

                                                } else {
                                                    $reg = $ot_diff;
                                                    $reg_8 = null;
                                                    $nd = $ot_difference - $ot_diff;
                                                }
                                            }
                                        }
                                    }
                                } else {
                                    if ( $ot_difference <= 8 ) {
                                        $reg = $ot_difference;
                                        $reg_8 = null;
                                        $nd = null;
                                    } else {
                                        $reg = 8;
                                        $reg_8 = $ot_difference-$reg;
                                        $nd = null;
                                    }
                                }
                                $overtime->LGL = $reg;
                                $overtime->LGL_8 = $reg_8;
                                $overtime->LGL_ND1 = $nd;
                            }
                            // SPECIAL HOLIDAY
                            if ( $type->id == 4) {
                                $model = $overtime;
                                $this->function->statusSystemLog($this->module,$string,$id);
                                // NIGHT DIFF
                                if ( $overtime->ot_time_out < '0400' OR $overtime->ot_time_out >= $nightdiff ) {
                                    if ( $overtime->ot_time_in < $nightdiff ) {
                                        // IF NIGHT DIFF IS EQUAL OR LESS THAN 8HRS
                                        if ( $ot_difference <= 8 ) {
                                            // IF OT TIME IN IS GREATER THAN 10PM AND LESS THAN 4AM 
                                            $reg = null;
                                            $reg_8 = null;
                                            $nd = $ot_difference;
                                        }
                                        if ( $ot_difference > 8 ) {
                                            if ( $overtime->ot_time_in < $nightdiff ) {
                                                $ot_diff = (strtotime($nightdiff) - $time1)/3600;
                                                if ( $ot_diff > 8 ) {
                                                    $reg = 8;
                                                    $reg_8 = $ot_diff-$reg;
                                                    $nd = $ot_difference - $ot_diff;

                                                } else {
                                                    $reg = $ot_diff;
                                                    $reg_8 = null;
                                                    $nd = $ot_difference - $ot_diff;
                                                }
                                            }
                                        }
                                    }
                                } else {
                                    if ( $ot_difference <= 8 ) {
                                        $reg = $ot_difference;
                                        $reg_8 = null;
                                        $nd = null;
                                    } else {
                                        $reg = 8;
                                        $reg_8 = $ot_difference-$reg;
                                        $nd = null;
                                    }
                                }
                                $overtime->SPL = $reg;
                                $overtime->SPL_8 = $reg_8;
                                $overtime->SPL_ND1 = $nd;
                            }
                            // LEGAL HOLIDAY ON REST DAY
                            if ( $type->id == 5) {
                                $model = $overtime;
                                $this->function->statusSystemLog($this->module,$string,$id);
                                // NIGHT DIFF
                                if ( $overtime->ot_time_out < '0400' OR $overtime->ot_time_out >= $nightdiff ) {
                                    if ( $overtime->ot_time_in < $nightdiff ) {
                                        // IF NIGHT DIFF IS EQUAL OR LESS THAN 8HRS
                                        if ( $ot_difference <= 8 ) {
                                            // IF OT TIME IN IS GREATER THAN 10PM AND LESS THAN 4AM 
                                            $reg = null;
                                            $reg_8 = null;
                                            $nd = $ot_difference;
                                        }
                                        if ( $ot_difference > 8 ) {
                                            if ( $overtime->ot_time_in < $nightdiff ) {
                                                $ot_diff = (strtotime($nightdiff) - $time1)/3600;
                                                if ( $ot_diff > 8 ) {
                                                    $reg = 8;
                                                    $reg_8 = $ot_diff-$reg;
                                                    $nd = $ot_difference - $ot_diff;

                                                } else {
                                                    $reg = $ot_diff;
                                                    $reg_8 = null;
                                                    $nd = $ot_difference - $ot_diff;
                                                }
                                            }
                                        }
                                    }
                                } else {
                                    if ( $ot_difference <= 8 ) {
                                        $reg = $ot_difference;
                                        $reg_8 = null;
                                        $nd = null;
                                    } else {
                                        $reg = 8;
                                        $reg_8 = $ot_difference-$reg;
                                        $nd = null;
                                    }
                                }
                                $overtime->LGLRST = $reg;
                                $overtime->LGLRST_8 = $reg_8;
                                $overtime->LGLRST_ND1 = $nd;
                            }
                            // SPECIAL HOLIDAY ON REST DAY
                            if ( $type->id == 6) {
                                $model = $overtime;
                                $this->function->statusSystemLog($this->module,$string,$id);
                                // NIGHT DIFF
                                if ( $overtime->ot_time_out < '0400' OR $overtime->ot_time_out >= $nightdiff ) {
                                    if ( $overtime->ot_time_in < $nightdiff ) {
                                        // IF NIGHT DIFF IS EQUAL OR LESS THAN 8HRS
                                        if ( $ot_difference <= 8 ) {
                                            // IF OT TIME IN IS GREATER THAN 10PM AND LESS THAN 4AM 
                                            $reg = null;
                                            $reg_8 = null;
                                            $nd = $ot_difference;
                                        }
                                        if ( $ot_difference > 8 ) {
                                            if ( $overtime->ot_time_in < $nightdiff ) {
                                                $ot_diff = (strtotime($nightdiff) - $time1)/3600;
                                                if ( $ot_diff > 8 ) {
                                                    $reg = 8;
                                                    $reg_8 = $ot_diff-$reg;
                                                    $nd = $ot_difference - $ot_diff;

                                                } else {
                                                    $reg = $ot_diff;
                                                    $reg_8 = null;
                                                    $nd = $ot_difference - $ot_diff;
                                                }
                                            }
                                        }
                                    }
                                } else {
                                    if ( $ot_difference <= 8 ) {
                                        $reg = $ot_difference;
                                        $reg_8 = null;
                                        $nd = null;
                                    } else {
                                        $reg = 8;
                                        $reg_8 = $ot_difference-$reg;
                                        $nd = null;
                                    }
                                }
                                $overtime->SPLRST = $reg;
                                $overtime->SPLRST_8 = $reg_8;
                                $overtime->SPLRST_ND1 = $nd;
                            }
                        } else {

                        }
                    }
                    if ( $status == 2 ) {
                        $msg = 'denied';
                    }
                    $overtime->status = $status;
                    $overtime->approved_by_id = $_SESSION['sys_id'];
                    $overtime->role_id = $_SESSION['sys_role_ids'];
                    $overtime->approved_date = date('Y-m-d H:i:s');
                    $overtime->overtime_type_id = request('type');
                    $overtime->supervisor_remarks = request('supervisor_remarks');
                    $overtime->update();
                    return redirect('/hris/pages/time/overtime/index')->with('success', 'Overtime request '.$msg.'!');
                } else {
                    return redirect('/hris/pages/time/overtime/index')->withErrors(['Invalid status.']);
                }
            } else {
                return back()->withErrors($this->supervisorData());
            }
        } else {
            if (in_array($id, $es_id)) {
                $id = $overtime->id;
                $attributes = array_keys($overtime->getAttributes());
                if ($this->supervisorData()) {
                    if ( $status == 1 or $status == 2 ) {
                        if ( $status == 1) {
                            $msg = 'approved';
                            $type = hris_overtime_types::find($request->type);
                            $category = hris_overtime_categories::find($overtime->overtime_category_id);
                            if ($category->name == 'RELIEVER' or $category->name == 'reliever') {
                                // REGULAR
                                if ( $type->id == 1) {
                                    $model = $overtime;
                                    $this->function->statusSystemLog($this->module,$string,$id);
                                    // NIGHT DIFF
                                    if ( $overtime->ot_time_out < '0400' OR $overtime->ot_time_out >= $nightdiff ) {
                                        if ( $overtime->ot_time_in < $nightdiff ) {
                                            // IF NIGHT DIFF IS EQUAL OR LESS THAN 8HRS
                                            if ( $ot_difference <= 8 ) {
                                                // IF OT TIME IN IS GREATER THAN 10PM AND LESS THAN 4AM 
                                                $reg = null;
                                                $reg_8 = null;
                                                $nd = $ot_difference;
                                            }
                                            if ( $ot_difference > 8 ) {
                                                if ( $overtime->ot_time_in < $nightdiff ) {
                                                    $ot_diff = (strtotime($nightdiff) - $time1)/3600;
                                                    if ( $ot_diff > 8 ) {
                                                        $reg = 8;
                                                        $reg_8 = $ot_diff-$reg;
                                                        $nd = $ot_difference - $ot_diff;

                                                    } else {
                                                        $reg = $ot_diff;
                                                        $reg_8 = null;
                                                        $nd = $ot_difference - $ot_diff;
                                                    }
                                                }
                                            }
                                        }
                                    } else {
                                        if ( $ot_difference <= 8 ) {
                                            $reg = $ot_difference;
                                            $reg_8 = null;
                                            $nd = null;
                                        } else {
                                            $reg = 8;
                                            $reg_8 = $ot_difference-$reg;
                                            $nd = null;
                                        }
                                    }
                                    $overtime->REG = $reg;
                                    $overtime->REG_8 = $reg_8;
                                    $overtime->REG_ND1 = $nd;
                                }
                                // REST DAY
                                if ( $type->id == 2) {
                                    $model = $overtime;
                                    $this->function->statusSystemLog($this->module,$string,$id);
                                    // NIGHT DIFF
                                    if ( $overtime->ot_time_out < '0400' OR $overtime->ot_time_out >= $nightdiff ) {
                                        if ( $overtime->ot_time_in < $nightdiff ) {
                                            // IF NIGHT DIFF IS EQUAL OR LESS THAN 8HRS
                                            if ( $ot_difference <= 8 ) {
                                                // IF OT TIME IN IS GREATER THAN 10PM AND LESS THAN 4AM 
                                                $reg = null;
                                                $reg_8 = null;
                                                $nd = $ot_difference;
                                            }
                                            if ( $ot_difference > 8 ) {
                                                if ( $overtime->ot_time_in < $nightdiff ) {
                                                    $ot_diff = (strtotime($nightdiff) - $time1)/3600;
                                                    if ( $ot_diff > 8 ) {
                                                        $reg = 8;
                                                        $reg_8 = $ot_diff-$reg;
                                                        $nd = $ot_difference - $ot_diff;

                                                    } else {
                                                        $reg = $ot_diff;
                                                        $reg_8 = null;
                                                        $nd = $ot_difference - $ot_diff;
                                                    }
                                                }
                                            }
                                        }
                                    } else {
                                        if ( $ot_difference <= 8 ) {
                                            $reg = $ot_difference;
                                            $reg_8 = null;
                                            $nd = null;
                                        } else {
                                            $reg = 8;
                                            $reg_8 = $ot_difference-$reg;
                                            $nd = null;
                                        }
                                    }
                                    $overtime->RST = $reg;
                                    $overtime->RST_8 = $reg_8;
                                    $overtime->RST_ND1 = $nd;
                                }
                                // LEGAL HOLIDAY
                                if ( $type->id == 3) {
                                    $model = $overtime;
                                    $this->function->statusSystemLog($this->module,$string,$id);
                                    // NIGHT DIFF
                                    if ( $overtime->ot_time_out < '0400' OR $overtime->ot_time_out >= $nightdiff ) {
                                        if ( $overtime->ot_time_in < $nightdiff ) {
                                            // IF NIGHT DIFF IS EQUAL OR LESS THAN 8HRS
                                            if ( $ot_difference <= 8 ) {
                                                // IF OT TIME IN IS GREATER THAN 10PM AND LESS THAN 4AM 
                                                $reg = null;
                                                $reg_8 = null;
                                                $nd = $ot_difference;
                                            }
                                            if ( $ot_difference > 8 ) {
                                                if ( $overtime->ot_time_in < $nightdiff ) {
                                                    $ot_diff = (strtotime($nightdiff) - $time1)/3600;
                                                    if ( $ot_diff > 8 ) {
                                                        $reg = 8;
                                                        $reg_8 = $ot_diff-$reg;
                                                        $nd = $ot_difference - $ot_diff;

                                                    } else {
                                                        $reg = $ot_diff;
                                                        $reg_8 = null;
                                                        $nd = $ot_difference - $ot_diff;
                                                    }
                                                }
                                            }
                                        }
                                    } else {
                                        if ( $ot_difference <= 8 ) {
                                            $reg = $ot_difference;
                                            $reg_8 = null;
                                            $nd = null;
                                        } else {
                                            $reg = 8;
                                            $reg_8 = $ot_difference-$reg;
                                            $nd = null;
                                        }
                                    }
                                    $overtime->LGL = $reg;
                                    $overtime->LGL_8 = $reg_8;
                                    $overtime->LGL_ND1 = $nd;
                                }
                                // SPECIAL HOLIDAY
                                if ( $type->id == 4) {
                                    $model = $overtime;
                                    $this->function->statusSystemLog($this->module,$string,$id);
                                    // NIGHT DIFF
                                    if ( $overtime->ot_time_out < '0400' OR $overtime->ot_time_out >= $nightdiff ) {
                                        if ( $overtime->ot_time_in < $nightdiff ) {
                                            // IF NIGHT DIFF IS EQUAL OR LESS THAN 8HRS
                                            if ( $ot_difference <= 8 ) {
                                                // IF OT TIME IN IS GREATER THAN 10PM AND LESS THAN 4AM 
                                                $reg = null;
                                                $reg_8 = null;
                                                $nd = $ot_difference;
                                            }
                                            if ( $ot_difference > 8 ) {
                                                if ( $overtime->ot_time_in < $nightdiff ) {
                                                    $ot_diff = (strtotime($nightdiff) - $time1)/3600;
                                                    if ( $ot_diff > 8 ) {
                                                        $reg = 8;
                                                        $reg_8 = $ot_diff-$reg;
                                                        $nd = $ot_difference - $ot_diff;

                                                    } else {
                                                        $reg = $ot_diff;
                                                        $reg_8 = null;
                                                        $nd = $ot_difference - $ot_diff;
                                                    }
                                                }
                                            }
                                        }
                                    } else {
                                        if ( $ot_difference <= 8 ) {
                                            $reg = $ot_difference;
                                            $reg_8 = null;
                                            $nd = null;
                                        } else {
                                            $reg = 8;
                                            $reg_8 = $ot_difference-$reg;
                                            $nd = null;
                                        }
                                    }
                                    $overtime->SPL = $reg;
                                    $overtime->SPL_8 = $reg_8;
                                    $overtime->SPL_ND1 = $nd;
                                }
                                // LEGAL HOLIDAY ON REST DAY
                                if ( $type->id == 5) {
                                    $model = $overtime;
                                    $this->function->statusSystemLog($this->module,$string,$id);
                                    // NIGHT DIFF
                                    if ( $overtime->ot_time_out < '0400' OR $overtime->ot_time_out >= $nightdiff ) {
                                        if ( $overtime->ot_time_in < $nightdiff ) {
                                            // IF NIGHT DIFF IS EQUAL OR LESS THAN 8HRS
                                            if ( $ot_difference <= 8 ) {
                                                // IF OT TIME IN IS GREATER THAN 10PM AND LESS THAN 4AM 
                                                $reg = null;
                                                $reg_8 = null;
                                                $nd = $ot_difference;
                                            }
                                            if ( $ot_difference > 8 ) {
                                                if ( $overtime->ot_time_in < $nightdiff ) {
                                                    $ot_diff = (strtotime($nightdiff) - $time1)/3600;
                                                    if ( $ot_diff > 8 ) {
                                                        $reg = 8;
                                                        $reg_8 = $ot_diff-$reg;
                                                        $nd = $ot_difference - $ot_diff;

                                                    } else {
                                                        $reg = $ot_diff;
                                                        $reg_8 = null;
                                                        $nd = $ot_difference - $ot_diff;
                                                    }
                                                }
                                            }
                                        }
                                    } else {
                                        if ( $ot_difference <= 8 ) {
                                            $reg = $ot_difference;
                                            $reg_8 = null;
                                            $nd = null;
                                        } else {
                                            $reg = 8;
                                            $reg_8 = $ot_difference-$reg;
                                            $nd = null;
                                        }
                                    }
                                    $overtime->LGLRST = $reg;
                                    $overtime->LGLRST_8 = $reg_8;
                                    $overtime->LGLRST_ND1 = $nd;
                                }
                                // SPECIAL HOLIDAY ON REST DAY
                                if ( $type->id == 6) {
                                    $model = $overtime;
                                    $this->function->statusSystemLog($this->module,$string,$id);
                                    // NIGHT DIFF
                                    if ( $overtime->ot_time_out < '0400' OR $overtime->ot_time_out >= $nightdiff ) {
                                        if ( $overtime->ot_time_in < $nightdiff ) {
                                            // IF NIGHT DIFF IS EQUAL OR LESS THAN 8HRS
                                            if ( $ot_difference <= 8 ) {
                                                // IF OT TIME IN IS GREATER THAN 10PM AND LESS THAN 4AM 
                                                $reg = null;
                                                $reg_8 = null;
                                                $nd = $ot_difference;
                                            }
                                            if ( $ot_difference > 8 ) {
                                                if ( $overtime->ot_time_in < $nightdiff ) {
                                                    $ot_diff = (strtotime($nightdiff) - $time1)/3600;
                                                    if ( $ot_diff > 8 ) {
                                                        $reg = 8;
                                                        $reg_8 = $ot_diff-$reg;
                                                        $nd = $ot_difference - $ot_diff;

                                                    } else {
                                                        $reg = $ot_diff;
                                                        $reg_8 = null;
                                                        $nd = $ot_difference - $ot_diff;
                                                    }
                                                }
                                            }
                                        }
                                    } else {
                                        if ( $ot_difference <= 8 ) {
                                            $reg = $ot_difference;
                                            $reg_8 = null;
                                            $nd = null;
                                        } else {
                                            $reg = 8;
                                            $reg_8 = $ot_difference-$reg;
                                            $nd = null;
                                        }
                                    }
                                    $overtime->SPLRST = $reg;
                                    $overtime->SPLRST_8 = $reg_8;
                                    $overtime->SPLRST_ND1 = $nd;
                                }
                            } else {

                            }
                        }
                        if ( $status == 2 ) {
                            $msg = 'denied';
                        }
                        $overtime->status = $status;
                        $overtime->approved_by_id = $_SESSION['sys_id'];
                        $overtime->role_id = $_SESSION['sys_role_ids'];
                        $overtime->approved_date = date('Y-m-d H:i:s');
                        $overtime->overtime_type_id = request('type');
                        $overtime->supervisor_remarks = request('supervisor_remarks');
                        $overtime->update();
                        return redirect('/hris/pages/time/overtime/index')->with('success', 'Overtime request '.$msg.'!');
                    } else {
                        return redirect('/hris/pages/time/overtime/index')->withErrors(['Invalid status.']);
                    }
                } else {
                    return back()->withErrors($this->supervisorData());
                } 
            }
        }
    }
    public function renderEmployee(Request $request){
        $department_id = $request->get('department_id');
        $employees = hris_employee::where('department_id',$department_id)->get();
        $output = '<option value="">-- select one --</option>';
        foreach ($employees as $employee) {
            $output .= '<option value="' . $employee->id . '">' . $employee->firstname . ' '. $employee->lastname .'</option>';
        }
        echo $output;
    }


    

    public function table()
    {
        $types = hris_overtime_types::all();
        $overtimes = hris_overtime::groupBy('employee_id')->selectRaw(
            'sum(REG) as REG_SUM, 
            sum(REG_8) as REG_8_SUM, 
            sum(REG_ND1) as REG_ND1_SUM, 
            sum(REG_ND2) as REG_ND2_SUM, 
            sum(RST) as RST_SUM, 
            sum(RST_8) as RST_8_SUM, 
            sum(RST_ND1) as RST_ND1_SUM, 
            sum(RST_ND2) as RST_ND2_SUM, 
            sum(LGL) as LGL_SUM, 
            sum(LGL_8) as LGL_8_SUM, 
            sum(LGL_ND1) as LGL_ND1_SUM, 
            sum(LGL_ND2) as LGL_ND2_SUM, 
            sum(LGLRST) as LGLRST_SUM, 
            sum(LGLRST_8) as LGLRST_8_SUM, 
            sum(LGLRST_ND1) as LGLRST_ND1_SUM, 
            sum(LGLRST_ND2) as LGLRST_ND2_SUM, 
            sum(SPL) as SPL_SUM, 
            sum(SPL_8) as SPL_8_SUM, 
            sum(SPL_ND1) as SPL_ND1_SUM, 
            sum(SPL_ND2) as SPL_ND2_SUM, 
            sum(SPLRST) as SPLRST_SUM, 
            sum(SPLRST_8) as SPLRST_8_SUM, 
            sum(SPLRST_ND1) as SPLRST_ND1_SUM, 
            sum(SPLRST_ND2) as SPLRST_ND2, 
            sum(SPRS_CLIEN) as SPRS_CLIEN_SUM, 
            sum(SPRS_CLIEN_8) as SPRS_CLIEN_8_SUM, 
            sum(SPRS_CLIEN_ND1) as SPRS_CLIEN_ND1_SUM, 
            sum(SPRS_CLIEN_ND2) as SPRS_CLIEN_ND2_SUM, 
            sum(LGRS_CLIEN) as LGRS_CLIEN_SUM, 
            sum(LGRS_CLIEN_8) as LGRS_CLIEN_8_SUM, 
            sum(LGRS_CLIEN_ND1) as LGRS_CLIEN_ND1_SUM, 
            sum(LGRS_CLIEN_ND2) as LGRS_CLIEN_ND2_SUM, 
            sum(SPL_CLIENT) as SPL_CLIENT_SUM, 
            sum(SPL_CLIENT_8) as SPL_CLIENT_8_SUM, 
            sum(SPL_CLIENT_ND1) as SPL_CLIENT_ND1_SUM, 
            sum(SPL_CLIENT_ND2) as SPL_CLIENT_ND2_SUM, 
            sum(RST_CLIENT) as RST_CLIENT_SUM, 
            sum(RST_CLIENT_8) as RST_CLIENT_8_SUM, 
            sum(RST_CLIENT_ND1) as RST_CLIENT_ND1_SUM, 
            sum(RST_CLIENT_ND2) as RST_CLIENT_ND2_SUM, 
            sum(REG_CLIENT) as REG_CLIENT_SUM, 
            sum(REG_CLIENT_8) as REG_CLIENT_8_SUM, 
            sum(REG_CLIENT_ND1) as REG_CLIENT_ND1_SUM, 
            sum(REG_CLIENT_ND2) as REG_CLIENT_ND2_SUM, 
            sum(REGND_CLIE) as REGND_CLIE_SUM, 
            sum(REGND_CLIE_8) as REGND_CLIE_8_SUM, 
            sum(REGND_CLIE_ND1) as REGND_CLIE_ND1_SUM, 
            sum(REGND_CLIE_ND2) as REGND_CLIE_ND2_SUM, 
            sum(LG_CLIENT) as LG_CLIENT_SUM, 
            sum(LG_CLIENT_8) as LG_CLIENT_8_SUM, 
            sum(LG_CLIENT_ND1) as LG_CLIENT_ND1_SUM, 
            sum(LG_CLIENT_ND2) as LG_CLIENT_ND2_SUM, 
            sum(LGLSPL) as LGLSPL_SUM, 
            sum(LGLSPL_8) as LGLSPL_8_SUM, 
            sum(LGLSPL_ND1) as LGLSPL_ND1_SUM, 
            sum(LGLSPL_ND2) as LGLSPL_ND2_SUM, 
            sum(LGLSPLRST) as LGLSPLRST_SUM, 
            sum(LGLSPLRST_8) as LGLSPLRST_8_SUM, 
            sum(LGLSPLRST_ND1) as LGLSPLRST_ND1_SUM, 
            sum(LGLSPLRST_ND2) as LGLSPLRST_ND2_SUM, 
            sum(LGLSPL_CLI) as LGLSPL_CLI_SUM, 
            sum(LGLSPL_CLI_8) as LGLSPL_CLI_8_SUM, 
            sum(LGLSPL_CLI_ND1) as LGLSPL_CLI_ND1_SUM, 
            sum(LGLSPL_CLI_ND2) as LGLSPL_CLI_ND2_SUM, 
            sum(LGLSPL_ND1_2) as LGLSPL_ND1_2_SUM, 
            sum(LGLSPL_ND1_2_8) as LGLSPL_ND1_2_8_SUM, 
            sum(LGLSPL_ND1_2_ND1) as LGLSPL_ND1_2_ND1_SUM, 
            sum(LGLSPL_ND1_2_ND2) as LGLSPL_ND1_2_ND2_SUM,
            employee_id'
        )->where('status', '1')->where('supervisor_id', $_SESSION['sys_id'])->get();
        return view('pages.time.overtime.table', compact('overtimes', 'types'));
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
        	'ot_time_out' => 'required|date_format:H:i',
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
            'type' => 'required',
            'supervisor_remarks' => 'required'
        ]);
    }

}



