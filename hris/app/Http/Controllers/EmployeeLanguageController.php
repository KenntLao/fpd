<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\hris_employee_languages;
use App\hris_employee;
use App\hris_languages;

class EmployeeLanguageController extends Controller
{
    private $function;
    private $module;

    public function __construct() {
        $this->function = new FunctionController;
        $this->module = 'Personal Information - Language';
    }
    public function index()
    {
        if ( $_SESSION['sys_account_mode'] == 'employee' ) {
            $employeeLanguages = hris_employee_languages::where('del_status', 0)->paginate(10);
            return view('pages.personalInformation.languages.index', compact('employeeLanguages'));
        } else {
            return back()->with(['You do not have access in this page.']);
        }
    }

    public function create(hris_employee_languages $employeeLanguage)
    {
        if ( $_SESSION['sys_account_mode'] == 'employee' ) {
            $languages = hris_languages::where('del_status', 0)->get();
            return view('pages.personalInformation.languages.create', compact('employeeLanguage', 'languages'));
        } else {
            return back()->with(['You do not have access in this page.']);
        }
    }

    public function store(hris_employee_languages $employeeLanguage, Request $request)
    {
        $employee_id = $_SESSION['sys_id'];
        if ($this->validatedData()) {
            $employeeLanguage->employee_id = $employee_id;
            $employeeLanguage->language_id = request('language_id');
            $employeeLanguage->reading = request('reading');
            $employeeLanguage->speaking = request('speaking');
            $employeeLanguage->writing = request('writing');
            $employeeLanguage->understanding = request('understanding');
            $employeeLanguage->save();
            $id = $employeeLanguage->id;
            $this->function->addSystemLog($this->module,$id);
            return redirect('/hris/pages/personalInformation/languages/index')->with('success', 'Employee language successfully added!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function show($id)
    {

    }

    public function edit(hris_employee_languages $employeeLanguage)
    {
        if ( $_SESSION['sys_account_mode'] == 'employee' ) {
            $languages = hris_languages::where('del_status', 0)->get();
            return view('pages.personalInformation.languages.edit', compact('employeeLanguage', 'languages'));
        } else {
            return back()->with(['You do not have access in this page.']);
        }
    }

    public function update(hris_employee_languages $employeeLanguage, Request $request)
    {
        $id = $employeeLanguage->id;
        if($this->validatedData()) {
            $string = 'App\hris_employee_languages';
            $employeeLanguage->language_id = request('language_id');
            $employeeLanguage->reading = request('reading');
            $employeeLanguage->speaking = request('speaking');
            $employeeLanguage->writing = request('writing');
            $employeeLanguage->understanding = request('understanding');
            // GET CHANGES
            $changes = $employeeLanguage->getDirty();
            // GET ORIGINAL DATA
            $this->function->getOldData($this->module,$string,$changes,$id);
            $employeeLanguage->update();
            // GET CHANGES
            $changed = $employeeLanguage->getChanges();
            // USE UPDATESYSTEMLOG FUNCTION
            $this->function->updateSystemLog($this->module,$changed,$string,$id);
            if ( $employeeLanguage->wasChanged() ) {
                return redirect('/hris/pages/personalInformation/languages/index')->with('success', 'Employee education successfully added!');
            } else {
                return redirect('/hris/pages/personalInformation/languages/index');
            }
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_employee_languages $employeeLanguage)
    {
        $id = $_SESSION['sys_id'];
        if ( $_SESSION['sys_account_mode'] == 'user' ) {
            return back()->with(['You do not have access in this page.']);
        } else {
            $employee = hris_employee::find($id);
            if ( Hash::check(request('password'), $employee->password) ) {
                $employeeLanguage->del_status = 1;
                $employeeLanguage->update();
                $id = $employeeLanguage->id;
                $this->function->deleteSystemLog($this->module,$id);
                return redirect('/hris/pages/personalInformation/languages/index')->with('success', 'Employee skill successfully deleted!');
            } else {
                return back()->withErrors(['Password does not match.']);
            }
        }
    }

    protected function validatedData()
    {
        return request()->validate([
            'language_id'=> 'required',
            'reading'=> 'required',
            'speaking'=> 'required',
            'writing'=> 'required',
            'understanding'=> 'required',
        ]);
    }

}
