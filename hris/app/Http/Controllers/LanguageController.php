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
        $languages = hris_languages::where('del_status', 0)->paginate(10);
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
            $attributes = array_keys($language->getAttributes());
            foreach ($attributes as $field) {
                if ( $field != 'id' AND $field != 'created_at' AND $field != 'updated_at' ) {
                    if ( $language->getOriginal($field) != request($field) ) {
                        $language->$field = request($field);
                    }
                }
            }
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
        if ( $_SESSION['sys_account_mode'] == 'user' ) {
            $upass = $this->function->decryptStr(users::find($id)->upass);
            if ( $upass == request('upass') ) {
                $language->del_status = 1;
                $language->update();
                $id = $language->id;
                $this->function->deleteSystemLog($this->module,$id);
                return redirect('/hris/pages/admin/qualifications/languages/index')->with('success', 'Language successfully deleted!');
            } else {
                return back()->withErrors(['Password does not match.']);
            }
        } else {
            $employee = hris_employee::find($id);
            if ( Hash::check(request('upass'), $employee->password) ) {
                $language->del_status = 1;
                $language->update();
                $id = $language->id;
                $this->function->deleteSystemLog($this->module,$id);
                return redirect('/hris/pages/admin/qualifications/languages/index')->with('success', 'Language successfully deleted!');
            } else {
                return back()->withErrors(['Password does not match.']);
            }
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
