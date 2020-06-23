<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\hris_department;
use App\users;

class DepartmentController extends Controller
{
    private $function;
    private $module;
    public function __construct()
    {
        $this->function = new FunctionController;
        $this->module = 'Administration - Department';
    }
    public function index(){
        $departments = hris_department::paginate(10);
        return view('pages.admin.department.index', compact('departments'));
    }
    public function create(hris_department $department)
    {
        return view('pages.admin.department.create', compact('department'));
    }
    public function store(Request $request, hris_department $department){
        $action = 'add';
        if ($this->validatedData()){
            if($department::where('department_code', '=', request('department_code'))->count() == 0) {
                $status = 0;
                $department->department_code = request('department_code');
                $department->department_name = request('department_name');
                $department->status = $status;
                $department->save();
                $id = $department->id;
                $this->function->systemLog($this->module,$action,$id);
                return redirect('/hris/pages/admin/department/index')->with('success', 'Department successfully added!');
            } else {
                return back()->withErrors('Department already exist');  
            }
        } else {
            return back()->withErrors($this->validatedData());  
        }
    }
    public function edit(hris_department $department){
        return view('pages.admin.department.edit', compact('department'));
    }
    public function update(Request $request, hris_department $department){
        $id = $department->id;
        if ($this->validatedData()) {
            if ($department::where('department_code', '=', request('department_code'))->count() == 0) {
                $this->function->updateSystemLog($model,$this->module,$id);
                $status = 0;
                $department->department_code = request('department_code');
                $department->department_name = request('department_name');
                $department->status = $status;
                $department->update();
                return redirect('/hris/pages/admin/department/index')->with('success', 'Department successfully updated!');
            } else {
                return back()->withErrors('Department already exist');
            }
        } else {
            return back()->withErrors($this->validatedData());
        }
    }
    public function destroy(hris_department $department){
        $action = 'delete';
        $id = $_SESSION['sys_id'];
        $upass = $this->function->decryptStr(users::find($id)->upass);
        if ($upass == request('upass')) {
            $department->delete();
            $id = $department->id;
            $this->function->systemLog($this->module, $action, $id);
            return redirect('/hris/pages/admin/department/index')->with('success', 'Department successfully deleted!');
        } else {
            return back()->withErrors(['Password does not match.']);
        }
    }

    protected function validatedData()
    {
        return request()->validate([
            'department_code' => 'required',
            'department_name' => 'required',
        ]);
    }

}
