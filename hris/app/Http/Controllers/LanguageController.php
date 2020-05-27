<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\hris_languages;

class LanguageController extends Controller
{
    public function index()
    {
        $languages = hris_languages::paginate(10);
        return view('pages.admin.qualifications.languages.index', compact('languages'));
    }

    public function create(hris_languages $language)
    {
        return view('pages.admin.qualifications.languages.create', compact('language'));
    }

    public function store(Request $request)
    {
        $language = new hris_languages();
        if($this->validatedData()) {
            $language->name = request('name');
            $language->description = request('description');
            $language->save();
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
        if($this->validatedData()) {
            $language->name = request('name');
            $language->description = request('description');
            $language->update();
            return redirect('/hris/pages/admin/qualifications/languages/index')->with('success', 'Language successfully updated!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_languages $language)
    {
        $language->delete();
        return redirect('/hris/pages/admin/qualifications/languages/index')->with('success', 'Language successfully deleted!');
    }

    protected function validatedData() 
    {
        return request()->validate([
            'name' => 'required',
            'description' => 'required'
        ]);
    }

}
