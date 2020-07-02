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
        if($this->validatedData()) {
            $language = hris_languages::create($this->validatedData());
            $id = $language->id;
            $this->function->addSystemLog($this->module,$id);
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
            $string = 'App\hris_languages';
            $language->name = request('name');
            $language->description = request('description');
            // GET CHANGES
            $changes = $language->getDirty();
            // GET ORIGINAL DATA
            $this->function->getOldData($this->module,$string,$changes,$id);
            $language->update();
            // GET CHANGES
            $changed = $language->getChanges();
            // USE UPDATESYSTEMLOG FUNCTION
            $this->function->updateSystemLog($this->module,$changed,$string,$id);
            if ( $language->wasChanged() ) {
                return redirect('/hris/pages/admin/qualifications/languages/index')->with('success', 'Language successfully updated!');
            } else {
                return redirect('/hris/pages/admin/qualifications/languages/index');
            }
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_languages $language)
    {
        $id = $_SESSION['sys_id'];
        $upass = $this->function->decryptStr(users::find($id)->upass);
        if ( $upass == request('upass') ) {
            $language->delete();
            $id = $language->id;
            $this->function->deleteSystemLog($this->module,$id);
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
