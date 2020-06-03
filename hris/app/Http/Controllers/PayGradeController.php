<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\hris_pay_grades;
use App\users;

class PayGradeController extends Controller
{
    public function index()
    {
        $payGrades = hris_pay_grades::paginate(10);
        return view('pages.admin.jobDetails.payGrades.index', compact('payGrades'));
    }

    public function create(hris_pay_grades $payGrade)
    {
        return view('pages.admin.jobDetails.payGrades.create', compact('payGrade'));
    }

    public function store(Request $request)
    {
        $payGrade = new hris_pay_grades();
        if ($this->validatedData()) {
            $payGrade->name = request('name');
            $payGrade->currency = request('currency');
            $payGrade->min_salary = request('min_salary');
            $payGrade->max_salary = request('max_salary');
            $payGrade->save();
            return redirect('/hris/pages/admin/jobDetails/payGrades/index')->with('success', 'Pay Grade successfully added!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function show($id)
    {

    }

    public function edit(hris_pay_grades $payGrade)
    {
        return view('pages.admin.jobDetails.payGrades.edit', compact('payGrade'));
    }

    public function update(hris_pay_grades $payGrade ,Request $request)
    {
        if($this->validatedData()) {
            $payGrade->name = request('name');
            $payGrade->currency = request('currency');
            $payGrade->min_salary = request('min_salary');
            $payGrade->max_salary = request('max_salary');
            $payGrade->update();
            return redirect('/hris/pages/admin/jobDetails/payGrades/index')->with('success', 'Pay Grade successfully updated!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_pay_grades $payGrade)
    {
        $id = $_SESSION['sys_id'];
        $upass = $this->decryptStr(users::find($id)->upass);
        if ( $upass == request('upass') ) {
            $payGrade->delete();
            return redirect('/hris/pages/admin/jobDetails/payGrades/index')->with('success', 'Pay Grade successfully deleted!');
        } else {
            return back()->withErrors(['Password does not match.']);
        }
    }

    protected function validatedData() {

        return request()->validate([
            'name' => 'required',
            'currency' => 'required',
            'min_salary' => 'required',
            'max_salary' => 'required'
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
