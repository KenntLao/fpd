<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\hris_languages;
use App\users;

class LanguageController extends Controller
{
    private $function;
    private $module;

    public function __construct() {
        $this->function = new FunctionController;
        $this->module = 'Qualificatioins Setup - Language';
    }
    public function index()
    {
        $languages = hris_languages::paginate(10);
        return view('pages.admin.qualifications.languages.index', compact('languages'));
    }

    public function create(hris_languages $language)
    {
        return view('pages.admin.qualifications.languages.create', compact('language'));
    }

    public function store(hris_languages $language, Request $request)
    {
        $action = 'add';
        if($this->validatedData()) {
            $language = hris_languages::create($this->validatedData());
            $id = $language->id;
            $this->function->systemLog($this->module,$action,$id);
            return redirect('/hris/pages/admin/qualifications/languages/index')->with('success', 'Language successfully added!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function show($id)
    {

    }

    public function edit(hris_languages $language)
    {
        return view('pages.admin.qualifications.languages.edit', compact('language'));
    }

    public function update(hris_languages $language, Request $request)
    {
        $id = $language->id;
        if($this->validatedData()) {
            $model = $language;
            //DO systemLog function FROM SystemLogController
            $this->function->updateSystemLog($model,$this->module,$id);
            $language->update($this->validatedData());
            return redirect('/hris/pages/admin/qualifications/languages/index')->with('success', 'Language successfully updated!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_languages $language)
    {
        $action = 'delete';
        $id = $_SESSION['sys_id'];
        $upass = $this->function->decryptStr(users::find($id)->upass);
        if ( $upass == request('upass') ) {
            $language->delete();
            $id = $language->id;
            $this->function->systemLog($this->module,$action,$id);
            return redirect('/hris/pages/admin/qualifications/languages/index')->with('success', 'Language successfully deleted!');
        } else {
            return back()->withErrors(['Password does not match.']);
        }
    }

    protected function validatedData() 
    {
        return request()->validate([
            'name' => 'required',
            'description' => 'required'
        ]);
    }

}
