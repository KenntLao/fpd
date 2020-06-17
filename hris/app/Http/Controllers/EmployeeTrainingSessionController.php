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
        $action = 'add';
        if($this->validatedData()) {
            $employeeTrainingSession = hris_employee_training_sessions::create($this->validatedData());
            $id = $employeeTrainingSession->id;
            $this->function->systemLog($this->module,$action,$id);
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
            $model = $employeeTrainingSession;
            //DO systemLog function FROM SystemLogController
            $this->function->updateSystemLog($model,$this->module,$id);
            $employeeTrainingSession->update($this->validatedData());
            return redirect('/hris/pages/admin/training/employeeTrainingSessions/index')->with('success', 'Employee training session successfully updated!');

        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_employee_training_sessions $employeeTrainingSession)
    {
        $action = 'delete';
        $id = $_SESSION['sys_id'];
        $upass = $this->function->decryptStr(users::find($id)->upass);
        if ( $upass == request('upass') ) {
            $employeeTrainingSession->delete();
            $id = $employeeTrainingSession->id;
            $this->function->systemLog($this->module,$action,$id);
            return redirect('/hris/pages/admin/training/employeeTrainingSessions/index')->with('success', 'Employee training session successfully deleted!');
        } else {
            return back()->withErrors(['Password does not match.']);
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
