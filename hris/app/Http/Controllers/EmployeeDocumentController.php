<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\users;
use App\hris_employee;
use App\hris_document_types;
use App\hris_employee_documents;

class EmployeeDocumentController extends Controller
{
    private $function;
    private $module;

    public function __construct() {
        $this->function = new FunctionController;
        $this->module = 'Document Management - Employee Document';
    }
    public function index()
    {
        $documents = hris_employee_documents::paginate(10);
        return view('pages.employees.documents.employeeDocuments.index', compact('documents'));
    }

    public function create(hris_employee_documents $document)
    {
        $employees = hris_employee::all();
        $types = hris_document_types::all();
        return view('pages.employees.documents.employeeDocuments.create', compact('document', 'employees', 'types'));
    }

    public function store(hris_employee_documents $document, Request $request)
    {   
        $action = 'add';
        if ($this->validatedData()) {
            if($request->hasFile('attachment')) {
                $attachment = time() . '.' . $request->attachment->extension();
                $document->attachment = $attachment;
                $request->attachment->move(public_path('assets/files/employees/documents/employee_documents'), $attachment);
            }
            $document->employee_id = request('employee_id');
            $document->type_id = request('type_id');
            $document->date_added = request('date_added');
            $document->valid_until = request('valid_until');
            $document->status = request('status');
            $document->details = request('details');
            $document->attachment = request('attachment');
            $document->save();
            $id = $document->id;
            $this->function->systemLog($this->module,$action,$id);
            return redirect('/hris/pages/employees/documents/employeeDocuments/index')->with('success','Employee document successfully added!');

        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function show($id)
    {

    }

    public function edit(hris_employee_documents $document)
    {
        $employees = hris_employee::all();
        $types = hris_document_types::all();
        return view('pages.employees.documents.employeeDocuments.edit', compact('document', 'employees', 'types'));
    }

    public function update(hris_employee_documents $document, Request $request)
    {   
        $id = $document->id;
        if ($this->validatedData()) {
            $model = $document;
            if( $request->hasFile('attachment') ) {
                $path = public_path('/assets/files/employees/documents/employee_documents/');
                if ($document->attachment != '' && $document->attachment != NULL) {
                    $attachment = $path . $document->attachment;
                    unlink($attachment);
                    $attachment = time() . '.' . $request->attachment->extension();
                    $document->attachment = $attachment;
                    $request->attachment->move($path, $attachment);
                } else {
                    $attachment = time() . '.' . $request->attachment->extension();
                    $document->attachment = $attachment;
                    $request->attachment->move($path, $attachment);
                }
            }
            //DO systemLog function FROM SystemLogController
            $this->function->updateSystemLog($model,$this->module,$id);
            $document->employee_id = request('employee_id');
            $document->type_id = request('type_id');
            $document->date_added = request('date_added');
            $document->valid_until = request('valid_until');
            $document->status = request('status');
            $document->details = request('details');
            $document->update();
            return redirect('/hris/pages/employees/documents/employeeDocuments/index')->with('success','Employee document successfully updated!');

        } else {
            return back()->withErrors($this->validatedData());
        }

    }

    public function destroy(hris_employee_documents $document)
    {
        $action = 'delete';
        $id = $_SESSION['sys_id'];
        $upass = $this->function->decryptStr(users::find($id)->upass);
        if ( $upass == request('upass') ) {
            $document->delete();
            $path = public_path('/assets/files/employees/documents/employee_documents/');
            if ($document->attachment != '' && $document->attachment != NULL) {
                $old = $path . $document->attachment;
                unlink($old);
            }
            $id = $document->id;
            $this->function->systemLog($this->module,$action,$id);
            return redirect('/hris/pages/employees/documents/employeeDocuments/index')->with('success','Employee document successfully deleted!');
        } else {
            return back()->withErrors(['Password does not match.']);
        }
    }

    protected function validatedData()
    {
        return request()->validate([
            'employee_id' => 'required',
            'type_id' => 'required',
            'date_added' => 'required',
            'valid_until' => 'nullable',
            'status' => 'required',
            'details' => 'nullable',
        ]);
    }

}