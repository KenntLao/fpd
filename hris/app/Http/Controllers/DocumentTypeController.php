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
        $types = hris_document_types::paginate(10);
        return view('pages.employees.documents.types.index', compact('types'));
    }

    public function create(hris_document_types $type)
    {
        return view('pages.employees.documents.types.create', compact('type'));
    }

    public function store(hris_document_types $type, Request $request)
    {
        $action = 'add';
        if ($this->validatedData()) {
            $type = hris_document_types::create($this->validatedData());
            $id = $type->id;
            $this->function->systemLog($this->module,$action,$id);
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
            $model = $type;
            //DO systemLog function FROM SystemLogController
            $this->function->updateSystemLog($model,$this->module,$id);
            $type->update($this->validatedData());
            return redirect('/hris/pages/employees/documents/types/index')->with('success', 'Document type successfully updated!');
        } else {
            return back()->withErrors($this->validatedData);
        } 
    }

    public function destroy(hris_document_types $type)
    {
        $action = 'delete';
        $id = $_SESSION['sys_id'];
        $upass = $this->function->decryptStr(users::find($id)->upass);
        if ( $upass == request('upass') ) {
            $type->delete();
            $id = $type->id;
            $this->function->systemLog($this->module,$action,$id);
            return redirect('/hris/pages/employees/documents/types/index')->with('success','Document type successfully deleted!');
        } else {
            return back()->withErrors(['Password does not match.']);
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
