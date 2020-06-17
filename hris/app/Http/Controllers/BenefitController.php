<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\hris_benefits;
use App\users;

class BenefitController extends Controller
{
    private $function;
    private $module;

    public function __construct() {
        $this->function = new FunctionController;
        $this->module = 'Recruitment Setup - Benefit';
    }
    public function index()
    {   
        $benefits = hris_benefits::orderBy('id')->paginate(10);
        return view('pages.recruitment.recruitmentSetup.benefits.index', compact('benefits'));
    }

    public function create(hris_benefits $benefit)
    {
        return view('pages.recruitment.recruitmentSetup.benefits.create', compact('benefit'));
    }

    public function store(hris_benefits $benefit, Request $request)
    {
        $action = 'add';
        if ($this->validatedData()) {
            $benefit = hris_benefits::create($this->validatedData());
            $id = $benefit->id;
            $this->function->systemLog($this->module,$action,$id);
            return redirect('/hris/pages/recruitment/recruitmentSetup/benefits/index')->with('success', 'Benefit successfully added!');
        } else {
            return back()->withErrors($this->validatedData);
        }

    }

    public function show($id)
    {
        //
    }

    public function edit(hris_benefits $benefit)
    {
        return view('pages.recruitment.recruitmentSetup.benefits.edit', compact('benefit'));
    }

    public function update(hris_benefits $benefit, Request $request)
    {
        $id = $benefit->id;
        if ($this->validatedData()) {
            $model = $benefit;
            //DO systemLog function FROM SystemLogController
            $this->function->updateSystemLog($model,$this->module,$id);
            $benefit->update($this->validatedData());
            return redirect('/hris/pages/recruitment/recruitmentSetup/benefits/index')->with('success', 'Benefit successfully updated!');
        } else {
            return back()->withErrors($this->validatedData);
        } 
    }


    public function destroy(hris_benefits $benefit)
    {
        $action = 'delete';
        $id = $_SESSION['sys_id'];
        $upass = $this->function->decryptStr(users::find($id)->upass);
        if ( $upass == request('upass') ) {
            $benefit->delete();
            $id = $benefit->id;
            $this->function->systemLog($this->module,$action,$id);
            return redirect('/hris/pages/recruitment/recruitmentSetup/benefits/index')->with('success','Benefit successfully deleted!');
        } else {
            return back()->withErrors(['Password does not match.']);
        }
    }

    protected function validatedData()
    {
        return request()->validate([
            'name' => 'required|max:100'
        ]);
    }
}