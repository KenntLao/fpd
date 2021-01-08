<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\hris_employee_training_sessions;
use App\hris_training_sessions;
use App\hris_courses;
use App\users;
use App\hris_employee;

class EmployeeTrainingSessionController extends Controller
{
    private $function;
    private $module;

    public function __construct() {
        $this->function = new FunctionController;
        $this->module = 'Training Setup - Employee Training Session';
    }
    public function index()
    {
        $employeeTrainingSessions = hris_employee_training_sessions::where('del_status', 0)->paginate(10);
        return view('pages.admin.training.employeeTrainingSessions.index', compact('employeeTrainingSessions'));
    }

    public function create(hris_employee_training_sessions $employeeTrainingSession)
    {
        $employees = hris_employee::where('del_status', 0)->get();
        $trainingSessions = hris_training_sessions::where('del_status', 0)->get();
        return view('pages.admin.training.employeeTrainingSessions.create', compact('employeeTrainingSession', 'trainingSessions', 'employees'));
    }

    public function show(hris_employee_training_sessions $employeeTrainingSession)
    {
        return view('pages.admin.training.employeeTrainingSessions.show', compact('employeeTrainingSession'));
    }

    public function store(hris_employee_training_sessions $employeeTrainingSession, Request $request)
    {
        if($this->validatedData()) {
            $employeeTrainingSession->employee_id = request('employee_id');
            $employeeTrainingSession->training_session_id = request('training_session_id');
            $employeeTrainingSession->status = '0';
            if ( $employeeTrainingSession->training_session->course->coordinator->id == request('employee_id') ) {
                return back()->withErrors(['Cannot add training session to employee with same coordinator.']);
            } else {
                if ( $employeeTrainingSession->training_session->attendance_type == 'Sign Up' ) {
                    $employeeTrainingSession->signup = '0';
                } else {
                   $employeeTrainingSession->signup = '1';
                }
                $employeeTrainingSession->save();
                $id = $employeeTrainingSession->id;
                $this->function->addSystemLog($this->module,$id);
                return redirect('/hris/pages/admin/training/employeeTrainingSessions/index')->with('success', 'Employee training session successfully added!');
            }

        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function edit(hris_employee_training_sessions $employeeTrainingSession)
    {
        $employees = hris_employee::where('del_status', 0)->get();
        $trainingSessions = hris_training_sessions::where('del_status', 0)->get();
        return view('pages.admin.training.employeeTrainingSessions.edit', compact('employeeTrainingSession', 'trainingSessions', 'employees'));
    }

    public function update(hris_employee_training_sessions $employeeTrainingSession, Request $request)
    {
        $id = $employeeTrainingSession->id;
        if($this->validatedData()) {
            $string = 'App\hris_employee_training_sessions';
            $employeeTrainingSession->employee_id = request('employee_id');
            $employeeTrainingSession->training_session_id = request('training_session_id');
            if ( $employeeTrainingSession->training_session->attendance_type == 'Sign Up' ) {
                $employeeTrainingSession->signup = '0';
            } else {
                $employeeTrainingSession->signup = '1';
            }
            // GET CHANGES
            $changes = $employeeTrainingSession->getDirty();
            // GET ORIGINAL DATA
            $this->function->getOldData($this->module,$string,$changes,$id);
            $employeeTrainingSession->update();
            // GET CHANGES
            $changed = $employeeTrainingSession->getChanges();
            // USE UPDATESYSTEMLOG FUNCTION
            $this->function->updateSystemLog($this->module,$changed,$string,$id);
            if ( $employeeTrainingSession->wasChanged() ) {
                return redirect('/hris/pages/admin/training/employeeTrainingSessions/index')->with('success', 'Employee training session successfully updated!');
            } else {
                return redirect('/hris/pages/admin/training/employeeTrainingSessions/index');
            }

        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_employee_training_sessions $employeeTrainingSession)
    {
        $id = $_SESSION['sys_id'];
        if ( $_SESSION['sys_account_mode'] == 'user' ) {
            $upass = $this->function->decryptStr(users::find($id)->upass);
            if ( $upass == request('upass') ) {
                $employeeTrainingSession->del_status = 1;
                $employeeTrainingSession->update();
                $id = $employeeTrainingSession->id;
                $this->function->deleteSystemLog($this->module,$id);
                return redirect('/hris/pages/admin/training/employeeTrainingSessions/index')->with('success', 'Employee training session successfully deleted!');
            } else {
                return back()->withErrors(['Password does not match.']);
            }
        } else {
            $employee = hris_employee::find($id);
            if ( Hash::check(request('upass'), $employee->password) ) {
                $employeeTrainingSession->del_status = 1;
                $employeeTrainingSession->update();
                $id = $employeeTrainingSession->id;
                $this->function->deleteSystemLog($this->module,$id);
                return redirect('/hris/pages/admin/training/employeeTrainingSessions/index')->with('success', 'Employee training session successfully deleted!');
            } else {
                return back()->withErrors(['Password does not match.']);
            }
        }
    }

    public function myTraining() {
        if ( $_SESSION['sys_role_ids'] == ',1,' ) {
            return back()->withErrors(['You do not have access in this page.']);
        } else {
            $employeeTrainingSessions = hris_employee_training_sessions::where('employee_id', $_SESSION['sys_id'])->where('del_status', 0)->paginate(10);
            return view('pages.training.myTraining.index', compact('employeeTrainingSessions'));
        }
    }

    public function signUp(hris_employee_training_sessions $employeeTrainingSession)
    {
        $employeeTrainingSession->signup = '1';
        $employeeTrainingSession->update();
        return redirect('/hris/pages/training/myTraining/index')->with('success', 'Signed up successfully!');
    }

    public function completedForm(hris_employee_training_sessions $employeeTrainingSession)
    {
        return view('pages.training.myTraining.complete', compact('employeeTrainingSession'));
    }

    public function editComplete(hris_employee_training_sessions $employeeTrainingSession)
    {
        return view('pages.training.myTraining.edit', compact('employeeTrainingSession'));
    }

    public function updateComplete(hris_employee_training_sessions $employeeTrainingSession,  Request $request)
    {
        if ( $this->complete() ) {
            if ($request->hasFile('proof')) {
                $path = public_path('assets/files/training/');
                if ($employeeTrainingSession->proof != '' && $employeeTrainingSession->proof != NULL) {
                    $old_file = $path . $employeeTrainingSession->proof;
                    unlink($old_file);
                    $proof = time() . 'PROOF.' . $request->proof->getClientOriginalExtension();
                    $employeeTrainingSession->proof = $proof;
                    $request->proof->move($path, $proof);
                } else {
                    $proof = time() . 'PROOF.' . $request->proof->getClientOriginalExtension();
                    $employeeTrainingSession->proof = $proof;
                    $request->proof->move($path, $proof);
                }
            }
            $employeeTrainingSession->feedback = request('feedback');
            $employeeTrainingSession->update();
            return redirect('/hris/pages/training/myTraining/index')->with('success', 'Training session updated!');

        } else {
            return back()->withErrors($this->complete());
        }
    }

    public function completed(hris_employee_training_sessions $employeeTrainingSession, Request $request)
    {
        if ( $this->complete() ) {
            if($request->hasFile('proof')) {
                $proof = time() . 'PROOF.' . $request->proof->getClientOriginalExtension();
                $employeeTrainingSession->proof = $proof;
                $request->proof->move(public_path('assets/files/training'), $proof);
            }
            $employeeTrainingSession->status = '3';
            $employeeTrainingSession->feedback = request('feedback');
            $employeeTrainingSession->update();
            return redirect('/hris/pages/training/myTraining/index')->with('success', 'Training session completed!');

        } else {
            return back()->withErrors($this->complete());
        }
    }

    public function completeDownload(hris_employee_training_sessions $employeeTrainingSession)
    {
        $file = public_path('assets/files/training/'.$employeeTrainingSession->proof);
        return response()->download($file);
    }

    public function notAttended(hris_employee_training_sessions $employeeTrainingSession)
    {
        $employeeTrainingSession->status = '2';
        $employeeTrainingSession->update();
        return redirect('/hris/pages/training/myTraining/index')->with('success', 'Training session not attended!');
    }

    public function showTraining(hris_employee_training_sessions $employeeTrainingSession)
    {
        return view('pages.training.myTraining.show', compact('employeeTrainingSession'));
    }

    public function coordinated()
    {
        if ( $_SESSION['sys_role_ids'] == ',1,' ) {
            return back()->withErrors(['You do not have access in this page.']);
        } else {
            $courses = hris_courses::where('del_status', 0)->where('coordinator_id', $_SESSION['sys_id'])->pluck('id')->toArray();
            $employeeTrainingSessions = hris_training_sessions::where('del_status', 0)->whereIn('course_id', $courses)->paginate(10);
            return view('pages.training.coordinated.index', compact('employeeTrainingSessions'));
        }

    }

    public function showCoordinated(hris_training_sessions $employeeTrainingSession)
    {
        if ( $_SESSION['sys_role_ids'] == ',1,' ) {
            return back()->withErrors(['You do not have access in this page.']);
        } else {
            $id = $_SESSION['sys_id'];
            $employee = hris_employee::find($id);
            return view('pages.training.coordinated.show', compact('employeeTrainingSession', 'employee'));
        }
    }

    public function coordinatedDownload(hris_training_sessions $employeeTrainingSession)
    {
        $file = public_path('assets/files/training_session/'.$employeeTrainingSession->attachment);
        return response()->download($file);
    }

    public function approve(hris_employee_training_sessions $employeeTrainingSession)
    {
        $employeeTrainingSession->status = '1';
        $employeeTrainingSession->update();
        return redirect('/hris/pages/admin/training/employeeTrainingSessions/index')->with('success', 'Employee training session approved!');
    }
    public function deny(hris_employee_training_sessions $employeeTrainingSession)
    {
        $employeeTrainingSession->status = '2';
        $employeeTrainingSession->update();
        return redirect('/hris/pages/admin/training/employeeTrainingSessions/index')->with('success', 'Employee training session denied!');
    }

    protected function validatedData() 
    {
        return request()->validate([
            'employee_id' => 'required',
            'training_session_id' => 'required'
        ]);
    }

    protected function complete()
    {
        return request()->validate([
            'proof' => 'required'
        ]);
    }

}
