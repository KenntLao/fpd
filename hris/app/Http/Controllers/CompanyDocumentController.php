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
    private $systemLog;
    private $module;

    public function __construct() {
        $this->systemLog = new SystemLogController;
        $this->module = 'Document Management - Company Document';
    }
    public function index()
    {
        $documents = hris_company_documents::paginate(10);
        return view('pages.employees.documents.companyDocuments.index', compact('documents'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(hris_company_documents $document)
    {
        $departments = hris_department::all();
        $employees = hris_employee::all();
        $department_id = array();
        $employee_id = array();
        return view('pages.employees.documents.companyDocuments.create', compact('document', 'departments', 'employees', 'department_id', 'employee_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
            $this->systemLog->systemLog($this->module,$action,$id);
            return redirect('/hris/pages/employees/documents/companyDocuments/index')->with('success', 'Company document successfully added!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
            $this->systemLog->updateSystemLog($model,$this->module,$id);
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(hris_company_documents $document)
    {
        $action = 'delete';
        $id = $_SESSION['sys_id'];
        $upass = $this->decryptStr(users::find($id)->upass);
        if ( $upass == request('upass') ) {
            $document->delete();
            $path = public_path('/assets/files/employees/documents/company_documents/');
            if ($document->attachment != '' && $document->attachment != NULL) {
                $old = $path . $document->attachment;
                unlink($old);
            }
            $id = $document->id;
            $this->systemLog->systemLog($this->module,$action,$id);
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
    // decrypt string
    function decryptStr($str) {
        $key = '4507';
        $c = base64_decode($str);
        $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
        $iv = substr($c,0,$ivlen);
        $hmac = substr($c,$ivlen,$sha2len=32);
        $ciphertext_raw = substr($c,$ivlen+$sha2len);
        $original_plaintext = openssl_decrypt($ciphertext_raw,$cipher,$key,$options=OPENSSL_RAW_DATA,$iv);
        $calcmac = hash_hmac('sha256',$ciphertext_raw,$key,$as_binary=true);
        if (hash_equals($hmac,$calcmac)) { return $original_plaintext; }
    }
}
