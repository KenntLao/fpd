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
        if($this->validatedData()) {
            $holiday = hris_holidays::create($this->validatedData());
            $id = $holiday->id;
            $this->function->addSystemLog($this->module,$id);
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
            $string = 'App\hris_holidays';
            $holiday->name = request('name');
            $holiday->holiday_date = request('holiday_date');
            $holiday->ot_type = request('ot_type');
            $holiday->status = request('status');
            $holiday->country = request('country');
            // GET CHANGES
            $changes = $holiday->getDirty();
            // GET ORIGINAL DATA
            $this->function->getOldData($this->module,$string,$changes,$id);
            $holiday->update();
            // GET CHANGES
            $changed = $holiday->getChanges();
            // USE UPDATESYSTEMLOG FUNCTION
            $this->function->updateSystemLog($this->module,$changed,$string,$id);
            if ( $holiday->wasChanged() ) {
                return redirect('/hris/pages/admin/leave/holidays/index')->with('success', 'Holiday successfully updated!');
            } else {
                return redirect('/hris/pages/admin/leave/holidays/index');
            }
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_holidays $holiday)
    {
        $id = $_SESSION['sys_id'];
        if ( $_SESSION['sys_account_mode'] == 'user' ) {
            $upass = $this->function->decryptStr(users::find($id)->upass);
            if ( $upass == request('upass') ) {
                $holiday->delete();
                $id = $holiday->id;
                $this->function->deleteSystemLog($this->module,$id);
                return redirect('/hris/pages/admin/leave/holidays/index')->with('success', 'Holiday successfully deleted!');
            } else {
                return back()->withErrors(['Password does not match.']);
            }
        } else {
            $employee = hris_employee::find($id);
            if ( Hash::check(request('upass'), $employee->password) ) {
                $holiday->delete();
                $id = $holiday->id;
                $this->function->deleteSystemLog($this->module,$id);
                return redirect('/hris/pages/admin/leave/holidays/index')->with('success', 'Holiday successfully deleted!');
            } else {
                return back()->withErrors(['Password does not match.']);
            }
        }
    }

    protected function validatedData()
    {
        return request()->validate([
            'name' => 'required',
            'holiday_date' => 'required',
            'ot_type' => 'required',
            'status' => 'required',
            'country' => 'nullable'
        ]);
    }

}
