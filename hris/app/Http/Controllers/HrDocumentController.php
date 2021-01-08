<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\hris_hrDocument;
use App\hris_employee;
use App\users;
class HrDocumentController extends Controller
{
    //
    private $function;
    private $module;

    public function __construct()
    {
        $this->function = new FunctionController;
        $this->module = 'Hr Documents';
    }
    public function index()
    {
        $documents = hris_hrDocument::where('del_status', 0)->paginate(10);
        return view('pages.documents.hrDocuments.index', compact('documents'));
    }
    public function create(hris_hrDocument $document)
    {

        return view('pages.documents.hrDocuments.create', compact('document'));
    }

    public function store(Request $request, hris_hrDocument $document){
        $path = public_path('assets/docs/hrdocs/');
        if($this->validatedData()) {
            $file = $request->hrdocs;

            $file_name = uniqid() . '_' . trim($file->getClientOriginalName());
            $file->move($path, $file_name);
            
            $document->document_name = $file_name;
            $document->save();
            return redirect('/hris/pages/documents/hrDocuments/index')->with('success', 'Documents successfully added!');
        }
    }
    public function download(hris_hrDocument $document){
        $file_name = $document->document_name;
        $file_path = public_path('assets/docs/hrdocs/' . $file_name);
        return response()->download($file_path);
    }
    public function destroy(hris_hrDocument $document)
    {
        $id = $_SESSION['sys_id'];
        if ($_SESSION['sys_account_mode'] == 'user') {
            $upass = $this->function->decryptStr(users::find($id)->upass);
            if ($upass == request('upass')) {
                $document->del_status = 1;
                $document->update();
                $id = $document->id;
                $this->function->deleteSystemLog($this->module, $id);
                return redirect('/hris/pages/documents/hrDocuments/index')->with('success', 'document successfully deleted!');
            } else {
                return back()->withErrors(['Password does not match.']);
            }
        } else {
            $employee = hris_employee::find($id);
            if (Hash::check(request('upass'), $employee->password)) {
                $document->del_status = 1;
                $document->update();
                $id = $document->id;
                $this->function->deleteSystemLog($this->module, $id);
                return redirect('/hris/pages/documents/hrDocuments/index')->with('success', 'document successfully deleted!');
            } else {
                return back()->withErrors(['Password does not match.']);
            }
        }
    }

    protected function validatedData()
    {
        return request()->validate([
            'hrdocs' => 'mimes:pdf,docx,doc,xls',
        ]);
    }

}
