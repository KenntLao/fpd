<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\hris_experience_levels;
use App\users;

class ExperienceLevelController extends Controller
{

    public function index()
    {   
        $experienceLevels = hris_experience_levels::paginate(10);
        return view('pages.recruitment.recruitmentSetup.experienceLevels.index', compact('experienceLevels'));
    }

    public function create(hris_experience_levels $experienceLevel)
    {
        return view('pages.recruitment.recruitmentSetup.experienceLevels.create', compact('experienceLevel'));
    }

    public function store(hris_experience_levels $experienceLevel, Request $request)
    {
        if ($this->validatedData()) {
            $experienceLevel::create($this->validatedData());
            return redirect('/hris/pages/recruitment/recruitmentSetup/experienceLevels/index')->with('success', 'Experience level added!');
        } else {
            return back()->withErrors($this->validatedData());
        }

    }

    public function show($id)
    {
        //
    }

    public function edit(hris_experience_levels $experienceLevel)
    {
        return view('pages.recruitment.recruitmentSetup.experienceLevels.edit', compact('experienceLevel'));
    }

    public function update(hris_experience_levels $experienceLevel, Request $request)
    {
        if ($this->validatedData()) {
            $experienceLevel->update($this->validatedData());
            return redirect('/hris/pages/recruitment/recruitmentSetup/experienceLevels/index')->with('success', 'Experience level updated!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_experience_levels $experienceLevel)
    {
        $id = $_SESSION['sys_id'];
        $upass = $this->decryptStr(users::find($id)->upass);
        if ( $upass == request('upass') ) {
            $experienceLevel->delete();
            return redirect('/hris/pages/recruitment/recruitmentSetup/experienceLevels/index')->with('success','Experience level deleted!');
        } else {
            return back()->withErrors(['Password does not match.']);
        }
    }

    protected function validatedData()
    {
        return request()->validate([
            'name' => 'required|max:100'
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