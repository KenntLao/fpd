<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\hris_clients;
use App\users;

class ClientController extends Controller
{
    private $systemLog;
    private $module;

    public function __construct() {
        $this->systemLog = new SystemLogController;
        $this->module = 'Properties Setup - Client';
    }
    public function index()
    {
        $clients = hris_clients::paginate(10);
        return view('pages.admin.properties.clients.index', compact('clients'));
    }

    public function create(hris_clients $client)
    {
        return view('pages.admin.properties.clients.create', compact('client'));
    }

    public function store(hris_clients $client, Request $request)
    {
        if($this->validatedData()) {
            $client = hris_clients::create($this->validatedData());
            $id = $client->id;
            $this->systemLog->systemLog($this->module,$action,$id);
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
        $id = $client->id;
        if($this->validatedData()) {
            $model = $client;
            //DO systemLog function FROM SystemLogController
            $this->systemLog->updateSystemLog($model,$this->module,$id);
            $client->update($this->validatedData());
            return redirect('/hris/pages/admin/properties/clients/index')->with('success', 'Client successfully updated!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_clients $client)
    {
        $action = 'delete';
        $id = $_SESSION['sys_id'];
        $upass = $this->decryptStr(users::find($id)->upass);
        if ( $upass == request('upass') ) {
            $client->delete();
            $id = $client->id;
            $this->systemLog->systemLog($this->module,$action,$id);
            return redirect('/hris/pages/admin/properties/clients/index')->with('success', 'Client successfully deleted!');
        } else {
            return back()->withErrors(['Password does not match.']);
        }
    }

    protected function validatedData()
    {
        return request()->validate([
            'name' => 'required',
            'details' => 'nullable',
            'address' => 'nullable',
            'contact_number' => 'nullable',
            'email' => 'nullable',
            'company_url' => 'nullable',
            'status' => 'required',
            'first_contact_date' => 'nullable',
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
