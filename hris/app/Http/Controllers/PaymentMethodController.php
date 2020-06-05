<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\hris_payment_methods;
use App\users;

class PaymentMethodController extends Controller
{
    public function index()
    {
        $paymentMethods = hris_payment_methods::paginate(10);
        return view('pages.admin.benefits.paymentMethods.index', compact('paymentMethods'));
    }

    public function create(hris_payment_methods $paymentMethod)
    {
        return view('pages.admin.benefits.paymentMethods.create', compact('paymentMethod'));
    }

    public function store(hris_payment_methods $paymentMethod, Request $request)
    {
        $paymentMethod = new hris_payment_methods();
        if($this->validatedData()) {
            $paymentMethod::create($this->validatedData());
            return redirect('/hris/pages/admin/benefits/paymentMethods/index')->with('success', 'Payment method successfully added!');
        } else {
            return back()->with($this->validatedData());
        }
    }

    public function show($id)
    {

    }

    public function edit(hris_payment_methods $paymentMethod)
    {
        return view('pages.admin.benefits.paymentMethods.edit', compact('paymentMethod'));
    }

    public function update(hris_payment_methods $paymentMethod, Request $request)
    {
        if($this->validatedData()) {
            $paymentMethod->update($this->validatedData());
            return redirect('/hris/pages/admin/benefits/paymentMethods/index')->with('success', 'Payment method successfully updated!');
        } else {
            return back()->with($this->validatedData());
        }
    }

    public function destroy(hris_payment_methods $paymentMethod)
    {
        $id = $_SESSION['sys_id'];
        $upass = $this->decryptStr(users::find($id)->upass);
        if ( $upass == request('upass') ) {
            $paymentMethod->delete();
            return redirect('/hris/pages/admin/benefits/paymentMethods/index')->with('success', 'Payment method successfully deleted!');
        } else {
            return back()->withErrors(['Password does not match.']);
        }
    }

    protected function validatedData()
    {
        return request()->validate([
            'name' => 'required'
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
