<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\hris_employee_training_sessions;
use App\hris_training_sessions;
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
        $employeeTrainingSessions = hris_employee_training_sessions::paginate(10);
        return view('pages.admin.training.employeeTrainingSessions.index', compact('employeeTrainingSessions'));
    }

    public function create(hris_employee_training_sessions $employeeTrainingSession)
    {
        $employees = hris_employee::all();
        $trainingSessions = hris_training_sessions::all();
        return view('pages.admin.training.employeeTrainingSessions.create', compact('employeeTrainingSession', 'trainingSessions', 'employees'));
    }

    public function store(hris_employee_training_sessions $employeeTrainingSession, Request $request)
    {
        if($this->validatedData()) {
            $employeeTrainingSession = hris_employee_training_sessions::create($this->validatedData());
            $id = $employeeTrainingSession->id;
            $this->function->addSystemLog($this->module,$id);
            return redirect('/hris/pages/admin/training/employeeTrainingSessions/index')->with('success', 'Employee training session successfully added!');

        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function show($id)
    {

    }

    public function edit(hris_employee_training_sessions $employeeTrainingSession)
    {
        $employees = hris_employee::all();
        $trainingSessions = hris_training_sessions::all();
        return view('pages.admin.training.employeeTrainingSessions.edit', compact('employeeTrainingSession', 'trainingSessions', 'employees'));
    }

    public function update(hris_employee_training_sessions $employeeTrainingSession, Request $request)
    {
        $id = $employeeTrainingSession->id;
        if($this->validatedData()) {
            $string = 'App\hris_employee_training_sessions';
            $employeeTrainingSession->employee_id = request('employee_id');
            $employeeTrainingSession->training_session_id = request('training_session_id');
            $employeeTrainingSession->status = request('status');
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
                $employeeTrainingSession->delete();
                $id = $employeeTrainingSession->id;
                $this->function->deleteSystemLog($this->module,$id);
                return redirect('/hris/pages/admin/training/employeeTrainingSessions/index')->with('success', 'Employee training session successfully deleted!');
            } else {
                return back()->withErrors(['Password does not match.']);
            }
        } else {
            $employee = hris_employee::find($id);
            if ( Hash::check(request('upass'), $employee->password) ) {
                $employeeTrainingSession->delete();
                $id = $employeeTrainingSession->id;
                $this->function->deleteSystemLog($this->module,$id);
                return redirect('/hris/pages/admin/training/employeeTrainingSessions/index')->with('success', 'Employee training session successfully deleted!');
            } else {
                return back()->withErrors(['Password does not match.']);
            }
        }
    }

    protected function validatedData() 
    {
        return request()->validate([
            'employee_id' => 'required',
            'training_session_id' => 'required',
            'status' => 'required'
        ]);
    }

}
