<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\hris_certifications;
use App\users;

class CertificationController extends Controller
{
    private $function;
    private $module;

    public function __construct() {
        $this->function = new FunctionController;
        $this->module = 'Qualifications Setup - Certification';
    }
    public function index()
    {
        $certifications = hris_certifications::where('del_status', 0)->paginate(10);
        return view('pages.admin.qualifications.certifications.index', compact('certifications'));
    }

    public function create(hris_certifications $certification)
    {
        return view('pages.admin.qualifications.certifications.create', compact('certification'));
    }

    public function store(hris_certifications $certification, Request $request)
    {
        if($this->validatedData()) {
            $certification = hris_certifications::create($this->validatedData());
            $id = $certification->id;
            $this->function->addSystemLog($this->module,$id);
            return redirect('/hris/pages/admin/qualifications/certifications/index')->with('success', 'Certification successfully added!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function show($id)
    {

    }

    public function edit(hris_certifications $certification)
    {
        return view('pages.admin.qualifications.certifications.edit', compact('certification'));
    }

    public function update(hris_certifications $certification, Request $request)
    {
        $id = $certification->id;
        if($this->validatedData()) {
            $string = 'App\hris_certifications';
            $certification->name = request('name');
            $certification->description = request('description');
            // GET CHANGES
            $changes = $certification->getDirty();
            // GET ORIGINAL DATA
            $this->function->getOldData($this->module,$string,$changes,$id);
            $certification->update();
            // GET CHANGES
            $changed = $certification->getChanges();
            // USE UPDATESYSTEMLOG FUNCTION
            $this->function->updateSystemLog($this->module,$changed,$string,$id);
            if ( $certification->wasChanged() ) {
                return redirect('/hris/pages/admin/qualifications/certifications/index')->with('success', 'Certification successfully updated!');
            } else {
                return redirect('/hris/pages/admin/qualifications/certifications/index');
            }
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_certifications $certification)
    {
        $id = $_SESSION['sys_id'];
        if ( $_SESSION['sys_account_mode'] == 'user' ) {
            $upass = $this->function->decryptStr(users::find($id)->upass);
            if ( $upass == request('upass') ) {
                $certification->del_status = 1;
                $certification->update();
                $id = $certification->id;
                $this->function->deleteSystemLog($this->module,$id);
                return redirect('/hris/pages/admin/qualifications/certifications/index')->with('success', 'Certification successfully deleted!');
            } else {
                return back()->withErrors(['Password does not match.']);
            }
        } else {
            $employee = hris_employee::find($id);
            if ( Hash::check(request('upass'), $employee->password) ) {
                $certification->del_status = 1;
                $certification->update();
                $id = $certification->id;
                $this->function->deleteSystemLog($this->module,$id);
                return redirect('/hris/pages/admin/qualifications/certifications/index')->with('success', 'Certification successfully deleted!');
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
