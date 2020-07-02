<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\hris_employment_statuses;
use App\users;

class EmploymentStatusController extends Controller
{
    private $function;
    private $module;

    public function __construct() {
        $this->function = new FunctionController;
        $this->module = 'Job Details Setup - Employment Status';
    }
    public function index()
    {
        $employmentStatuses = hris_employment_statuses::paginate(10);
        return view('pages.admin.jobDetails.employmentStatuses.index', compact('employmentStatuses'));
    }

    public function create(hris_employment_statuses $employmentStatus)
    {
        return view('pages.admin.jobDetails.employmentStatuses.create', compact('employmentStatus'));
    }

    public function store(hris_employment_statuses $employmentStatus, Request $request)
    {
        if($this->validatedData()) {
            $employmentStatus = hris_employment_statuses::create($this->validatedData());
            $id = $employmentStatus->id;
            $this->function->addSystemLog($this->module,$id);
            return redirect('/hris/pages/admin/jobDetails/employmentStatuses/index')->with('success', 'Employment status successfully added!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function show($id)
    {

    }

    public function edit(hris_employment_statuses $employmentStatus)
    {
        return view('pages.admin.jobDetails.employmentStatuses.edit', compact('employmentStatus'));
    }

    public function update(hris_employment_statuses $employmentStatus ,Request $request)
    {
        $id = $employmentStatus->id;
        if($this->validatedData()) {
            $string = 'App\hris_employment_statuses';
            $employmentStatus->name = request('name');
            $employmentStatus->description = request('description');
            // GET CHANGES
            $changes = $employmentStatus->getDirty();
            // GET ORIGINAL DATA
            $this->function->getOldData($this->module,$string,$changes,$id);
            $employmentStatus->update();
            // GET CHANGES
            $changed = $employmentStatus->getChanges();
            // USE UPDATESYSTEMLOG FUNCTION
            $this->function->updateSystemLog($this->module,$changed,$string,$id);
            if ( $employmentStatus->wasChanged() ) {
                return redirect('/hris/pages/admin/jobDetails/employmentStatuses/index')->with('success', 'Employment Status successfully updated!');
            } else {
                return redirect('/hris/pages/admin/jobDetails/employmentStatuses/index');
            }
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_employment_statuses $employmentStatus)
    {
        $id = $_SESSION['sys_id'];
        $upass = $this->function->decryptStr(users::find($id)->upass);
        if ( $upass == request('upass') ) {
            $employmentStatus->delete();
            $id = $employmentStatus->id;
            $this->function->deleteSystemLog($this->module,$id);
            return redirect('/hris/pages/admin/jobDetails/employmentStatuses/index')->with('success', 'Employment status successfully deleted!');
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
