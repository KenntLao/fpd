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
    private $systemLog;
    private $module;

    public function __construct() {
        $this->systemLog = new SystemLogController;
        $this->module = 'Personal Information - Language';
    }
    public function index()
    {
        if ( $_SESSION['sys_account_mode'] == 'employee' ) {
            $employeeLanguages = hris_employee_languages::paginate(10);
            return view('pages.personalInformation.languages.index', compact('employeeLanguages'));
        }
    }

    public function create(hris_employee_languages $employeeLanguage)
    {
        $languages = hris_languages::all();
        return view('pages.personalInformation.languages.create', compact('employeeLanguage', 'languages'));
    }

    public function store(hris_employee_languages $employeeLanguage, Request $request)
    {
        $action = 'add';
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
            $this->systemLog->systemLog($this->module,$action,$id);
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
        $languages = hris_languages::all();
        return view('pages.personalInformation.languages.edit', compact('employeeLanguage', 'languages'));
    }

    public function update(hris_employee_languages $employeeLanguage, Request $request)
    {
        $id = $employeeLanguage->id;
        if($this->validatedData()) {
            $model = $employeeLanguage;
            //DO systemLog function FROM SystemLogController
            $this->systemLog->updateSystemLog($model,$this->module,$id);
            $employeeLanguage->update($this->validatedData());
            return redirect('/hris/pages/personalInformation/languages/index')->with('success', 'Employee education successfully added!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_employee_languages $employeeLanguage)
    {
        $action = 'delete';
        $id = $_SESSION['sys_id'];
        $employee = hris_employee::find($id);
        if ( Hash::check(request('password'), $employee->password) ) {
            $employeeLanguage->delete();
            $id = $employeeLanguage->id;
            $this->systemLog->systemLog($this->module,$action,$id);
            return redirect('/hris/pages/personalInformation/languages/index')->with('success', 'Employee skill successfully deleted!');
        } else {
            return back()->withErrors(['Password does not match.']);
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
