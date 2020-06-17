<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\hris_company_documents;
use App\hris_department;
use App\hris_employee;
use App\users;

class CompanyDocumentController extends Controller
{
    private $function;
    private $module;

    public function __construct() {
        $this->function = new FunctionController;
        $this->module = 'Document Management - Company Document';
    }
    public function index()
    {
        $documents = hris_company_documents::paginate(10);
        return view('pages.employees.documents.companyDocuments.index', compact('documents'));
    }

    public function create(hris_company_documents $document)
    {
        $departments = hris_department::all();
        $employees = hris_employee::all();
        $department_id = array();
        $employee_id = array();
        return view('pages.employees.documents.companyDocuments.create', compact('document', 'departments', 'employees', 'department_id', 'employee_id'));
    }

    public function store(hris_company_documents $document,Request $request)
    {
        $action = 'add';
        if ( request('department_id') == NULL ) {
            $department_id = '';
        } else {
            $department_id = implode(",", request('department_id'));
        }
        if ( request('employee_id') == NULL ) {
            $employee_id = '';
        } else {
            $employee_id = implode(",", request('employee_id'));
        }
        if($this->validatedData()) {
            if ( $request->hasFile('attachment') ) {
                $attachment = time() . '.' . $request->attachment->extension();
            }
            $document->name = request('name');
            $document->details = request('details');
            $document->status = request('status');
            $document->attachment = $attachment;
            $document->department_id = $department_id;
            $document->employee_id = $employee_id;
            $request->attachment->move(public_path('assets/files/employees/documents/company_documents'), $attachment);
            $document->save();
            $id = $document->id;
            $this->function->systemLog($this->module,$action,$id);
            return redirect('/hris/pages/employees/documents/companyDocuments/index')->with('success', 'Company document successfully added!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function show($id)
    {

    }

    public function edit(hris_company_documents $document)
    {
        $departments = hris_department::all();
        $employees = hris_employee::all();
        $department_id = explode(',', $document->department_id);
        if ($document->employee_id == NULL) {
            $employee_id = explode(',', $document->employee_id);
        } else {
            $employee_id = '';
        }
        return view('pages.employees.documents.companyDocuments.edit', compact('document', 'departments', 'employees', 'department_id', 'employee_id'));
    }

    public function update(hris_company_documents $document, Request $request)
    {
        $id = $document->id;
        if ( request('department_id') == NULL ) {
            $department_id = '';
        } else {
            $department_id = implode(",", request('department_id'));
        }
        if ( request('employee_id') == NULL ) {
            $employee_id = '';
        } else {
            $employee_id = implode(",", request('employee_id'));
        }
        if($this->validatedData()) {
            $model = $document;
            if( $request->hasFile('attachment') ) {
                $path = public_path('/assets/files/employees/documents/company_documents/');
                if ($document->profile_image != '' && $document->attachment != NULL) {
                    $old = $path . $document->attachment;
                    unlink($old);
                    $attachment = time() . '.' . $request->attachment->extension();
                    $document->attachment = $attachment;
                    $request->attachment->move($path, $attachment);
                } else {
                    $imageName = time() . '.' . $request->profile_image->extension();
                    $document->attachment = $attachment;
                    $request->attachment->move($path, $attachment);
                }
            }
            $this->function->updateSystemLog($model,$this->module,$id);
            $document->name = request('name');
            $document->details = request('details');
            $document->status = request('status');
            $document->department_id = $department_id;
            $document->employee_id = $employee_id;
            $document->update();
            $id = $document->id;
            return redirect('/hris/pages/employees/documents/companyDocuments/index')->with('success', 'Company document successfully updated!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_company_documents $document)
    {
        $action = 'delete';
        $id = $_SESSION['sys_id'];
        $upass = $this->function->decryptStr(users::find($id)->upass);
        if ( $upass == request('upass') ) {
            $document->delete();
            $path = public_path('/assets/files/employees/documents/company_documents/');
            if ($document->attachment != '' && $document->attachment != NULL) {
                $old = $path . $document->attachment;
                unlink($old);
            }
            $id = $document->id;
            $this->function->systemLog($this->module,$action,$id);
            return redirect('/hris/pages/employees/documents/companyDocuments/index')->with('success','Company document successfully deleted!');
        } else {
            return back()->withErrors(['Password does not match.']);
        }
    }
    protected function validatedData()
    {
        return request()->validate([
            'name' => 'required',
            'details' => 'nullable',
            'status' => 'required',
            'attachment' => 'nullable',
            'department_id' => 'nullable',
            'employee_id' => 'nullable'
        ]);
    }
}
