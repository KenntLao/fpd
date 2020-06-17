<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\hris_holidays;
use App\hris_countries;
use App\users;

class HolidayController extends Controller
{
    private $function;
    private $module;

    public function __construct() {
        $this->function = new FunctionController;
        $this->module = 'Leave Settings - Holiday';
    }
    public function index()
    {
        $holidays = hris_holidays::paginate(10);
        return view('pages.admin.leave.holidays.index', compact('holidays'));
    }

    public function create(hris_holidays $holiday)
    {
        $countries = hris_countries::all();
        return view('pages.admin.leave.holidays.create', compact('holiday', 'countries'));
    }

    public function store(hris_holidays $holiday, Request $request)
    {
        $action = 'add';
        if($this->validatedData()) {
            $holiday = hris_holidays::create($this->validatedData());
            $id = $holiday->id;
            $this->function->systemLog($this->module,$action,$id);
            return redirect('/hris/pages/admin/leave/holidays/index')->with('success', 'Holiday successfully added!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function show($id)
    {

    }

    public function edit(hris_holidays $holiday)
    {
        $countries = hris_countries::all();
        return view('pages.admin.leave.holidays.edit', compact('holiday', 'countries'));
    }

    public function update(hris_holidays $holiday, Request $request)
    {
        $id = $holiday->id;
        if($this->validatedData()) {
            $model = $holiday;
            //DO systemLog function FROM SystemLogController
            $this->function->updateSystemLog($model,$this->module,$id);
            $holiday->update($this->validatedData());
            return redirect('/hris/pages/admin/leave/holidays/index')->with('success', 'Holiday successfully updated!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_holidays $holiday)
    {
        $action = 'delete';
        $id = $_SESSION['sys_id'];
        $upass = $this->function->decryptStr(users::find($id)->upass);
        if ( $upass == request('upass') ) {
            $holiday->delete();
            $id = $holiday->id;
            $this->function->systemLog($this->module,$action,$id);
            return redirect('/hris/pages/admin/leave/holidays/index')->with('success', 'Holiday successfully deleted!');
        } else {
            return back()->withErrors(['Password does not match.']);
        }
    }

    protected function validatedData()
    {
        return request()->validate([
            'name' => 'required',
            'holiday_date' => 'required',
            'status' => 'required',
            'country' => 'nullable'
        ]);
    }

}
