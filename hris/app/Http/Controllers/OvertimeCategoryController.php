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
        $overtimeCategories = hris_overtime_categories::paginate(10);
        return view('pages.admin.overtime.overtimeCategories.index', compact('overtimeCategories'));
    }

    public function create(hris_overtime_categories $overtimeCategory)
    {
        return view('pages.admin.overtime.overtimeCategories.create', compact('overtimeCategory'));
    }

    public function store(hris_overtime_categories $overtimeCategory, Request $request)
    {
        $action = 'add';
        if($this->validatedData()) {
            $overtimeCategory = hris_overtime_categories::create($this->validatedData());
            $id = $jobTitle->id;
            $this->function->systemLog($this->module,$action,$id);
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
        $id = $jobTitle->id;
        if($this->validatedData()) {
            $model = $jobTitle;
            //DO systemLog function FROM SystemLogController
            $this->function->updateSystemLog($model,$this->module,$id);
            $overtimeCategory->update($this->validatedData());
            return redirect('/hris/pages/admin/overtime/overtimeCategories/index')->with('success', 'Overtime category successfully updated!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_overtime_categories $overtimeCategory)
    {
        $action = 'delete';
        $id = $_SESSION['sys_id'];
        $upass = $this->function->decryptStr(users::find($id)->upass);
        if ( $upass == request('upass') ) {
            $overtimeCategory->delete();
            $id = $jobTitle->id;
            $this->function->systemLog($this->module,$action,$id);
            return redirect('/hris/pages/admin/overtime/overtimeCategories/index')->with('success', 'Overtime category successfully deleted!');
        } else {
            return back()->withErrors(['Password does not match.']);
        }
    }

    protected function validatedData()
    {
        return request()->validate([
            'name' => 'required'
        ]);
    }
    
}
