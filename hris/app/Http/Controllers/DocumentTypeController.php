<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\users;
use App\hris_document_types;

class DocumentTypeController extends Controller
{
    private $function;
    private $module;

    public function __construct() {
        $this->function = new FunctionController;
        $this->module = 'Document Management - Document Type';
    }

    public function index()
    {
        $types = hris_document_types::where('del_status', 0)->paginate(10);
        return view('pages.employees.documents.types.index', compact('types'));
    }

    public function create(hris_document_types $type)
    {
        return view('pages.employees.documents.types.create', compact('type'));
    }

    public function store(hris_document_types $type, Request $request)
    {
        if ($this->validatedData()) {
            $type = hris_document_types::create($this->validatedData());
            $id = $type->id;
            $this->function->addSystemLog($this->module,$id);
            return redirect('/hris/pages/employees/documents/types/index')->with('success', 'Document type successfully added!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function show($id)
    {

    }

    public function edit(hris_document_types $type)
    {
        return view('pages.employees.documents.types.edit', compact('type'));
    }

    public function update(hris_document_types $type, Request $request)
    {
        $id = $type->id;
        if ($this->validatedData()) {
            $string = 'App\hris_document_types';
            $type->name = request('name');
            $type->notify_expiry = request('notify_expiry');
            $type->expire_notification_month = request('expire_notification_month');
            $type->expire_notification_week = request('expire_notification_week');
            $type->expire_notification_day = request('expire_notification_day');
            $type->details = request('details');
            // GET CHANGES
            $changes = $type->getDirty();
            // GET ORIGINAL DATA
            $this->function->getOldData($this->module,$string,$changes,$id);
            $type->update();
            // GET CHANGES
            $changed = $type->getChanges();
            // USE UPDATESYSTEMLOG FUNCTION
            $this->function->updateSystemLog($this->module,$changed,$string,$id);
            if ( $type->wasChanged() ) {
                return redirect('/hris/pages/employees/documents/types/index')->with('success', 'Document type successfully updated!');
            } else {
                return redirect('/hris/pages/employees/documents/types/index');
            }
        } else {
            return back()->withErrors($this->validatedData);
        } 
    }

    public function destroy(hris_document_types $type)
    {
        $id = $_SESSION['sys_id'];
        if ( $_SESSION['sys_account_mode'] == 'user' ) {
            $upass = $this->function->decryptStr(users::find($id)->upass);
            if ( $upass == request('upass') ) {
                $type->del_status = 1;
                $type->update();
                $id = $type->id;
                $this->function->deleteSystemLog($this->module,$id);
                return redirect('/hris/pages/employees/documents/types/index')->with('success','Document type successfully deleted!');
            } else {
                return back()->withErrors(['Password does not match.']);
            }
        } else {
            $employee = hris_employee::find($id);
            if ( Hash::check(request('upass'), $employee->password) ) {
                $type->del_status = 1;
                $type->update();
                $id = $type->id;
                $this->function->deleteSystemLog($this->module,$id);
                return redirect('/hris/pages/employees/documents/types/index')->with('success','Document type successfully deleted!');
            } else {
                return back()->withErrors(['Password does not match.']);
            }
        }
    }

    protected function validatedData()
    {
        return request()->validate([
            'name' => 'required',
            'notify_expiry' => 'required',
            'expire_notification_month' => 'required',
            'expire_notification_week' => 'required',
            'expire_notification_day' => 'required',
            'details' => 'nullable'
        ]);
    }

}
