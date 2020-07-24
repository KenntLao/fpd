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
        if ($this->validatedData()) {
            $benefit = hris_benefits::create($this->validatedData());
            $id = $benefit->id;
            $this->function->addSystemLog($this->module,$id);
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
            $string = 'App\hris_benefits';
            $benefit->name = request('name');
            // GET CHANGES
            $changes = $benefit->getDirty();
            // GET ORIGINAL DATA
            $this->function->getOldData($this->module,$string,$changes,$id);
            $benefit->update();
            // GET CHANGES
            $changed = $benefit->getChanges();
            // USE UPDATESYSTEMLOG FUNCTION
            $this->function->updateSystemLog($this->module,$changed,$string,$id);
            if ( $benefit->wasChanged() ) {
                return redirect('/hris/pages/recruitment/recruitmentSetup/benefits/index')->with('success', 'Benefit successfully updated!');
            } else {
                return redirect('/hris/pages/recruitment/recruitmentSetup/benefits/index');
            }
        } else {
            return back()->withErrors($this->validatedData);
        } 
    }


    public function destroy(hris_benefits $benefit)
    {
        $id = $_SESSION['sys_id'];
        if ( $_SESSION['sys_account_mode'] == 'user' ) {
            $upass = $this->function->decryptStr(users::find($id)->upass);
            if ( $upass == request('upass') ) {
                $benefit->delete();
                $id = $benefit->id;
                $this->function->deleteSystemLog($this->module,$id);
                return redirect('/hris/pages/recruitment/recruitmentSetup/benefits/index')->with('success','Benefit successfully deleted!');
            } else {
                return back()->withErrors(['Password does not match.']);
            }

        } else {
            $employee = hris_employee::find($id);
            if ( Hash::check(request('password'), $employee->password) ) {
                $benefit->delete();
                $id = $benefit->id;
                $this->function->deleteSystemLog($this->module,$id);
                return redirect('/hris/pages/recruitment/recruitmentSetup/benefits/index')->with('success','Benefit successfully deleted!');
            } else {
                return back()->withErrors(['Password does not match.']);
            }
        }
    }

    protected function validatedData()
    {
        return request()->validate([
            'name' => 'required|max:100'
        ]);
    }
}