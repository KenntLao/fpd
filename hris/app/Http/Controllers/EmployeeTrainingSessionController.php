<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\hris_employee_training_sessions;
use App\hris_training_sessions;

class EmployeeTrainingSessionController extends Controller
{
    public function index()
    {
        $employeeTrainingSessions = hris_employee_training_sessions::paginate(10);
        $id = hris_employee_training_sessions::all()->get('id');
        $training = hris_training_sessions::find($id);
        return view('pages.admin.training.employeeTrainingSessions.index', compact('employeeTrainingSessions', 'training'));
    }

    public function create(hris_employee_training_sessions $employeeTrainingSession)
    {
        $trainingSessions = hris_training_sessions::all();
        return view('pages.admin.training.employeeTrainingSessions.create', compact('employeeTrainingSession', 'trainingSessions'));
    }

    public function store(Request $request)
    {
        $employeeTrainingSession = new hris_employee_training_sessions();
        if($this->validatedData()) {
            $employeeTrainingSession->employee = request('employee');
            $employeeTrainingSession->training_session = request('training_session');
            $employeeTrainingSession->status = request('status');
            $employeeTrainingSession->save();
            return redirect('/hris/pages/admin/training/employeeTrainingSessions/index')->with('success', 'Employee Training Session successfully added!');

        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function show($id)
    {

    }

    public function edit(hris_employee_training_sessions $employeeTrainingSession)
    {
        $trainingSessions = hris_training_sessions::all();
        return view('pages.admin.training.employeeTrainingSessions.edit', compact('employeeTrainingSession', 'trainingSessions'));
    }

    public function update(hris_employee_training_sessions $employeeTrainingSession, Request $request)
    {
        if($this->validatedData()) {
            $employeeTrainingSession->employee = request('employee');
            $employeeTrainingSession->training_session = request('training_session');
            $employeeTrainingSession->status = request('status');
            $employeeTrainingSession->update();
            return redirect('/hris/pages/admin/training/employeeTrainingSessions/index')->with('success', 'Employee Training Session successfully updated!');

        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_employee_training_sessions $employeeTrainingSession)
    {
        $employeeTrainingSession->delete();
            return redirect('/hris/pages/admin/training/employeeTrainingSessions/index')->with('success', 'Employee Training Session successfully deleted!');
    }

    protected function validatedData() 
    {
        return request()->validate([
            'employee' => 'required',
            'training_session' => 'required',
            'status' => 'required'
        ]);
    }

}
