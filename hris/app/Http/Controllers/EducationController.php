<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\hris_educations;
use App\users;

class EducationController extends Controller
{
    private $function;
    private $module;

    public function __construct() {
        $this->function = new FunctionController;
        $this->module = 'Qualifications Setup - Education';
    }
    public function index()
    {
        $educations = hris_educations::paginate(10);
        return view('pages.admin.qualifications.educations.index', compact('educations'));
    }

    public function create(hris_educations $education)
    {
        return view('pages.admin.qualifications.educations.create', compact('education'));
    }

    public function store(hris_educations $education, Request $request)
    {
        if($this->validatedData()) {
            $education = hris_educations::create($this->validatedData());
            $id = $education->id;
            $this->function->addSystemLog($this->module,$id);
            return redirect('/hris/pages/admin/qualifications/educations/index')->with('success', 'Education successfully added!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function show($id)
    {

    }

    public function edit(hris_educations $education)
    {
        return view('pages.admin.qualifications.educations.edit', compact('education'));
    }

    public function update(hris_educations $education, Request $request)
    {
        $id = $education->id;
        if($this->validatedData()) {
            $string = 'App\hris_educations';
            $education->name = request('name');
            $education->description = request('description');
            // GET CHANGES
            $changes = $education->getDirty();
            // GET ORIGINAL DATA
            $this->function->getOldData($this->module,$string,$changes,$id);
            $education->update();
            // GET CHANGES
            $changed = $education->getChanges();
            // USE UPDATESYSTEMLOG FUNCTION
            $this->function->updateSystemLog($this->module,$changed,$string,$id);
            if ( $education->wasChanged() ) {
                return redirect('/hris/pages/admin/qualifications/educations/index')->with('success', 'Education successfully updated!');
            } else {
                return redirect('/hris/pages/admin/qualifications/educations/index');
            }
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_educations $education)
    {
        $id = $_SESSION['sys_id'];
        if ( $_SESSION['sys_account_mode'] == 'user' ) {
            $upass = $this->function->decryptStr(users::find($id)->upass);
            if ( $upass == request('upass') ) {
                $education->delete();
                $id = $education->id;
                $this->function->deleteSystemLog($this->module,$id);
                return redirect('/hris/pages/admin/qualifications/educations/index')->with('success', 'Education successfully deleted!');
            } else {
                return back()->withErrors(['Password does not match.']);
            }
        } else {
            $employee = hris_employee::find($id);
            if ( Hash::check(request('upass'), $employee->password) ) {
                $education->delete();
                $id = $education->id;
                $this->function->deleteSystemLog($this->module,$id);
                return redirect('/hris/pages/admin/qualifications/educations/index')->with('success', 'Education successfully deleted!');
            } else {
                return back()->withErrors(['Password does not match.']);
            }
        }
    }

    protected function validatedData() 
    {
        return request()->validate([
            'name' => 'required',
            'description' => 'required'
        ]);
    }

}
