<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\hris_employee_dependents;
use App\hris_employee;

class DependentController extends Controller
{
    private $function;
    private $module;

    public function __construct() {
        $this->function = new FunctionController;
        $this->module = 'Personal Information - Dependent';
    }
    public function index()
    {
        $id = $_SESSION['sys_id'];
        if ($_SESSION['sys_account_mode'] == 'employee') {
            $dependents = hris_employee_dependents::where('del_status', 0)->where('employee_id', $id)->paginate(10);
            return view('pages.personalInformation.dependents.index', compact('dependents'));
        } else {
            return back()->with(['You do not have access in this page.']);
        }
    }

    public function create(hris_employee_dependents $dependent)
    {
        if ($_SESSION['sys_account_mode'] == 'employee') {
            return view('pages.personalInformation.dependents.create', compact('dependent'));
        } else {
            return back()->with(['You do not have access in this page.']);
        }
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
            $dependend->del_status = 0;
            $dependent->save();
            $id = $dependent->id;
            $this->function->addSystemLog($this->module,$id);
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
        if ($_SESSION['sys_account_mode'] == 'employee') {
            return view('pages.personalInformation.dependents.edit', compact('dependent'));
        } else {
            return back()->with(['You do not have access in this page.']);
        }
    }

    public function update(hris_employee_dependents $dependent, Request $request)
    {
        $id = $dependent->id;
        if($this->validatedData()) {
            $string = 'App\hris_employee_dependents';
            $dependent->name = request('name');
            $dependent->relationship = request('relationship');
            $dependent->birthday = request('birthday');
            $dependent->id_number = request('id_number');
            // GET CHANGES
            $changes = $dependent->getDirty();
            // GET ORIGINAL DATA
            $this->function->getOldData($this->module,$string,$changes,$id);
            $dependent->update();
            // GET CHANGES
            $changed = $dependent->getChanges();
            // USE UPDATESYSTEMLOG FUNCTION
            $this->function->updateSystemLog($this->module,$changed,$string,$id);
            if ( $dependent->wasChanged() ) {
                return redirect('/hris/pages/personalInformation/dependents/index')->with('success', 'Dependent successfully updated!');
            } else {
                return redirect('/hris/pages/personalInformation/dependents/index');
            }
        } else {
            return back()->withErrors($this->validatedData);
        }
    }

    public function destroy(hris_employee_dependents $dependent)
    {
        $id = $_SESSION['sys_id'];
        if ( $_SESSION['sys_account_mode'] == 'user' ) {
            return back()->with(['You do not have access in this page.']);
        } else {
            $employee = hris_employee::find($id);
            if ( Hash::check(request('password'), $employee->password) ) {
                $dependent->del_status = 1;
                $dependent->update();
                $id = $dependent->id;
                $this->function->deleteSystemLog($this->module,$id);
                return redirect('/hris/pages/personalInformation/dependents/index')->with('success', 'Dependent successfully deleted!');
            } else {
                return back()->withErrors(['Password does not match.']);
            }
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
