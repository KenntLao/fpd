<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\hris_employee_dependents;
use App\hris_employee;

class DependentController extends Controller
{
    public function index()
    {
        if ($_SESSION['sys_account_mode'] == 'employee') {
            $dependents = hris_employee_dependents::paginate(10);
            return view('pages.personalInformation.dependents.index', compact('dependents'));
        }
    }

    public function create(hris_employee_dependents $dependent)
    {
        return view('pages.personalInformation.dependents.create', compact('dependent'));
    }

    public function store(hris_employee_dependents $dependent, Request $request)
    {
        $employee_id = $_SESSION['sys_id'];
        if($this->validatedData()) {
            $dependent->employee_id = $employee_id;
            $dependent->name = request('name');
            $dependent->relationship = request('relationship');
            $dependent->birthday = request('birthday');
            $dependent->id_number = request('id_number');
            $dependent->save();
            return redirect('/hris/pages/personalInformation/dependents/index')->with('success', 'Dependent successfully added!');
        } else {
            return back()->withErrors($this->validatedData);
        }
    }

    public function show($id)
    {

    }

    public function edit(hris_employee_dependents $dependent)
    {
        return view('pages.personalInformation.dependents.edit', compact('dependent'));
    }

    public function update(hris_employee_dependents $dependent, Request $request)
    {
        if($this->validatedData()) {
            $dependent->update($this->validatedData());
            return redirect('/hris/pages/personalInformation/dependents/index')->with('success', 'Dependent successfully updated!');
        } else {
            return back()->withErrors($this->validatedData);
        }
    }

    public function destroy(hris_employee_dependents $dependent)
    {
        $id = $_SESSION['sys_id'];
        $employee = hris_employee::find($id);
        if ( Hash::check(request('password'), $employee->password) ) {
            $dependent->delete();
            return redirect('/hris/pages/personalInformation/dependents/index')->with('success', 'Dependent successfully deleted!');
        } else {
            return back()->withErrors(['Password does not match.']);
        }
    }

    protected function validatedData()
    {
        return request()->validate([
            'name' => 'required',
            'relationship' => 'required',
            'birthday' => 'required',
            'id_number' => 'nullable'
        ]);
    }

}
