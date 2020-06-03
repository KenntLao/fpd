<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\hris_clients;
use App\users;

class ClientController extends Controller
{
    public function index()
    {
        $clients = hris_clients::paginate(10);
        return view('pages.admin.properties.clients.index', compact('clients'));
    }

    public function create(hris_clients $client)
    {
        return view('pages.admin.properties.clients.create', compact('client'));
    }

    public function store(Request $request)
    {
        $client = new hris_clients();
        if($this->validatedData()) {
            $client->name = request('name');
            $client->details = request('details');
            $client->address = request('address');
            $client->contact_number = request('contact_number');
            $client->email = request('email');
            $client->company_url = request('company_url');
            $client->status = request('status');
            $client->first_contact_date = request('first_contact_date');
            $client->save();
            return redirect('/hris/pages/admin/properties/clients/index')->with('success', 'Client successfully added!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function show($id)
    {

    }

    public function edit(hris_clients $client)
    {
        return view('pages.admin.properties.clients.edit', compact('client'));
    }

    public function update(hris_clients $client, Request $request)
    {
        if($this->validatedData()) {
            $client->name = request('name');
            $client->details = request('details');
            $client->address = request('address');
            $client->contact_number = request('contact_number');
            $client->email = request('email');
            $client->company_url = request('company_url');
            $client->status = request('status');
            $client->first_contact_date = request('first_contact_date');
            $client->update();
            return redirect('/hris/pages/admin/properties/clients/index')->with('success', 'Client successfully updated!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_clients $client)
    {
        $id = $_SESSION['sys_id'];
        $upass = $this->decryptStr(users::find($id)->upass);
        if ( $upass == request('upass') ) {
            $client->delete();
            return redirect('/hris/pages/admin/properties/clients/index')->with('success', 'Client successfully deleted!');
        } else {
            return back()->withErrors(['Password does not match.']);
        }
    }

    protected function validatedData()
    {
        return request()->validate([
            'name' => 'required',
            'status' => 'required'
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
