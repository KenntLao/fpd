<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\hris_company_documents;
use App\hris_company_structures;
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
        $departments = hris_company_structures::where('del_status', 0)->get();
        $employees = hris_employee::where('del_status', 0)->get();
        $department_id = array();
        $employee_id = array();
        return view('pages.employees.documents.companyDocuments.create', compact('document', 'departments', 'employees', 'department_id', 'employee_id'));
    }

    public function store(hris_company_documents $document,Request $request)
    {
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
        if($this->storeValidatedData()) {
            if ( $request->hasFile('attachment') ) {
                $attachment = time() . 'A.' . $request->attachment->extension();
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
            $this->function->addSystemLog($this->module,$id);
            return redirect('/hris/pages/employees/documents/companyDocuments/index')->with('success', 'Company document successfully added!');
        } else {
            return back()->withErrors($this->storeValidatedData());
        }
    }

    public function show($id)
    {

    }

    public function edit(hris_company_documents $document)
    {
        $departments = hris_company_structures::where('del_status', 0)->get();
        $employees = hris_employee::where('del_status', 0)->get();
        if ($document->department_id != NULL) {
            $department_id = explode(',', $document->department_id);
        } else {
            $department_id = array();
        }
        if ($document->employee_id != NULL) {
            $employee_id = explode(',', $document->employee_id);
        } else {
            $employee_id = array();
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
        if($this->updateValidatedData()) {
            $string = 'App\hris_company_documents';
            if( $request->hasFile('attachment') ) {
                $path = public_path('/assets/files/employees/documents/company_documents/');
                if ($document->attachment != '' && $document->attachment != NULL) {
                    $old = $path . $document->attachment;
                    unlink($old);
                    $attachment = time() . 'A.' . $request->attachment->extension();
                    $document->attachment = $attachment;
                    $request->attachment->move($path, $attachment);
                }
            }
            $document->name = request('name');
            $document->details = request('details');
            $document->status = request('status');
            $document->department_id = $department_id;
            $document->employee_id = $employee_id;
            // GET CHANGES
            $changes = $document->getDirty();
            // GET ORIGINAL DATA
            $this->function->getOldData($this->module,$string,$changes,$id);
            $document->update();
            // GET CHANGES
            $changed = $document->getChanges();
            // USE UPDATESYSTEMLOG FUNCTION
            $this->function->updateSystemLog($this->module,$changed,$string,$id);
            if ( $document->wasChanged() ) {
                return redirect('/hris/pages/employees/documents/companyDocuments/index')->with('success', 'Company document successfully updated!');
            } else {
                return redirect('/hris/pages/employees/documents/companyDocuments/index');
            }
        } else {
            return back()->withErrors($this->updateValidatedData());
        }
    }

    public function destroy(hris_company_documents $document)
    {
        $id = $_SESSION['sys_id'];
        if ( $_SESSION['sys_account_mode'] == 'user' ) {
            $upass = $this->function->decryptStr(users::find($id)->upass);
            if ( $upass == request('upass') ) {
                $document->del_status = 1;
                $document->update();
                $id = $document->id;
                $this->function->deleteSystemLog($this->module,$id);
                return redirect('/hris/pages/employees/documents/companyDocuments/index')->with('success','Company document successfully deleted!');
            } else {
                return back()->withErrors(['Password does not match.']);
            }
        } else {
            $employee = hris_employee::find($id);
            if ( Hash::check(request('upass'), $employee->password) ) {
                $document->del_status = 1;
                $document->update();
                $id = $document->id;
                $this->function->deleteSystemLog($this->module,$id);
                return redirect('/hris/pages/employees/documents/companyDocuments/index')->with('success','Company document successfully deleted!');
            } else {
                return back()->withErrors(['Password does not match.']);
            }
        }
    }

    public function renderEmployee(hris_company_documents $document) {
        $employees = hris_employee::where('department_id', request('department_id'))->get();
        $output = '<option disabled default>--select one--</option>';
        foreach ($employees as $employee) {
            $output .= '<option value="' . $employee->id . '">' . $employee->firstname . ' '. $employee->lastname .'</option>';
        }
        echo $output;
    }


    protected function storeValidatedData()
    {
        return request()->validate([
            'name' => 'required',
            'details' => 'nullable',
            'status' => 'required',
            'attachment' => 'required',
            'department_id' => 'nullable',
            'employee_id' => 'nullable'
        ]);
    }
    protected function updateValidatedData()
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
