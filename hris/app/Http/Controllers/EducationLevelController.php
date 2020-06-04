<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\hris_education_levels;
use App\users;

class EducationLevelController extends Controller
{

    public function index()
    {   
        $educationLevels = hris_education_levels::paginate(10);
        return view('pages.recruitment.recruitmentSetup.educationLevels.index', compact('educationLevels'));
    }

    public function create(hris_education_levels $educationLevel)
    {
        return view('pages.recruitment.recruitmentSetup.educationLevels.create', compact('educationLevel'));
    }

    public function store(Request $request)
    {
        $educationLevel = new hris_education_levels();

        if ($this->validatedData()) {
            $educationLevel->name = request('name');
            $educationLevel->save();
            Log::channel('educationLevels')->info('A new education level has been added. Id: ' .$educationLevel->id. '. Name: '. $educationLevel->name. '.');
            return redirect('/hris/pages/recruitment/recruitmentSetup/educationLevels/index')->with('success', 'Education level successfully added!');
        } else {
            return back()->withErrors($this->validatedData);
        }
    }

    public function show($id)
    {
        //
    }

    public function edit(hris_education_levels $educationLevel)
    {
        return view('pages.recruitment.recruitmentSetup.educationLevels.edit', compact('educationLevel'));
    }

    public function update(hris_education_levels $educationLevel, Request $request)
    {
        if ($this->validatedData()) {
            $educationLevel->name = request('name');
            $educationLevel->update();
            Log::channel('educationLevels')->info('Education level id no.' .$educationLevel->id. ' has been updated. Name: '. $educationLevel->name. '.');
            return redirect('/hris/pages/recruitment/recruitmentSetup/educationLevels/index')->with('success', 'Education level successfully updated!');
        } else {
            return back()->withErrors($this->validatedData);
        } 
    }

    public function destroy(hris_education_levels $educationLevel)
    {
        $id = $_SESSION['sys_id'];
        $upass = $this->decryptStr(users::find($id)->upass);
        if ( $upass == request('upass') ) {
            $educationLevel->delete();
            Log::channel('educationLevels')->info('Education level id no.' .$educationLevel->id. ' has been deleted. Name: '. $educationLevel->name. '.');
            return redirect('/hris/pages/recruitment/recruitmentSetup/educationLevels/index')->with('success','Education level successfully deleted!');
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
