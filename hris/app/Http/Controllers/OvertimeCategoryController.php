<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\hris_overtime_categories;
use App\users;

class OvertimeCategoryController extends Controller
{
    private $function;
    private $module;

    public function __construct() {
        $this->function = new FunctionController;
        $this->module = 'Overtime Administration - Overtime Category';
    }
    public function index()
    {
        $overtimeCategories = hris_overtime_categories::where('del_status', 0)->paginate(10);
        return view('pages.admin.overtime.overtimeCategories.index', compact('overtimeCategories'));
    }

    public function create(hris_overtime_categories $overtimeCategory)
    {
        return view('pages.admin.overtime.overtimeCategories.create', compact('overtimeCategory'));
    }

    public function store(hris_overtime_categories $overtimeCategory, Request $request)
    {
        if($this->validatedData()) {
            $overtimeCategory = hris_overtime_categories::create($this->validatedData());
            $id = $overtimeCategory->id;
            $this->function->addSystemLog($this->module,$id);
            return redirect('/hris/pages/admin/overtime/overtimeCategories/index')->with('success', 'Overtime category successfully added!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function show($id)
    {

    }

    public function edit(hris_overtime_categories $overtimeCategory)
    {
        return view('pages.admin.overtime.overtimeCategories.edit', compact('overtimeCategory'));
    }

    public function update(hris_overtime_categories $overtimeCategory, Request $request)
    {
        $id = $overtimeCategory->id;
        if($this->validatedData()) {
            $string = 'App\hris_overtime_categories';
            $overtimeCategory->name = request('name');
            // GET CHANGES
            $changes = $overtimeCategory->getDirty();
            // GET ORIGINAL DATA
            $this->function->getOldData($this->module,$string,$changes,$id);
            $overtimeCategory->update();
            // GET CHANGES
            $changed = $overtimeCategory->getChanges();
            // USE UPDATESYSTEMLOG FUNCTION
            $this->function->updateSystemLog($this->module,$changed,$string,$id);
            if ( $overtimeCategory->wasChanged() ) {
                return redirect('/hris/pages/admin/overtime/overtimeCategories/index')->with('success', 'Overtime category successfully updated!');
            } else {
                return redirect('/hris/pages/admin/overtime/overtimeCategories/index');
            }
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_overtime_categories $overtimeCategory)
    {
        $id = $_SESSION['sys_id'];
        if ( $_SESSION['sys_account_mode'] == 'user' ) {
            $upass = $this->function->decryptStr(users::find($id)->upass);
            if ( $upass == request('upass') ) {
                $overtimeCategory->del_status = 1;
                $overtimeCategory->update();
                $id = $overtimeCategory->id;
                $this->function->deleteSystemLog($this->module,$id);
                return redirect('/hris/pages/admin/overtime/overtimeCategories/index')->with('success', 'Overtime category successfully deleted!');
            } else {
                return back()->withErrors(['Password does not match.']);
            }
        } else {
            $employee = hris_employee::find($id);
            if ( Hash::check(request('upass'), $employee->password) ) {
                $overtimeCategory->del_status = 1;
                $overtimeCategory->update();
                $id = $overtimeCategory->id;
                $this->function->deleteSystemLog($this->module,$id);
                return redirect('/hris/pages/admin/overtime/overtimeCategories/index')->with('success', 'Overtime category successfully deleted!');
            } else {
                return back()->withErrors(['Password does not match.']);
            }
        }
    }

    protected function validatedData()
    {
        return request()->validate([
            'name' => 'required'
        ]);
    }
    
}
