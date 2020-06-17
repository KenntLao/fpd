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
        $action = 'add';
        if($this->validatedData()) {
            $education = hris_educations::create($this->validatedData());
            $id = $education->id;
            $this->function->systemLog($this->module,$action,$id);
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
            $model = $education;
            //DO systemLog function FROM SystemLogController
            $this->function->updateSystemLog($model,$this->module,$id);
            $education->update($this->validatedData());
            return redirect('/hris/pages/admin/qualifications/educations/index')->with('success', 'Education successfully updated!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_educations $education)
    {
        $action = 'delete';
        $id = $_SESSION['sys_id'];
        $upass = $this->function->decryptStr(users::find($id)->upass);
        if ( $upass == request('upass') ) {
            $education->delete();
            $id = $education->id;
            $this->function->systemLog($this->module,$action,$id);
            return redirect('/hris/pages/admin/qualifications/educations/index')->with('success', 'Education successfully deleted!');
        } else {
            return back()->withErrors(['Password does not match.']);
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
