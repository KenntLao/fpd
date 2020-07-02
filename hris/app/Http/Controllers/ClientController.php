<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\hris_clients;
use App\users;

class ClientController extends Controller
{
    private $function;
    private $module;

    public function __construct() {
        $this->function = new FunctionController;
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
            $this->function->addSystemLog($this->module,$id);
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
            $string = 'App\hris_clients';
            $client->name = request('name');
            $client->details = request('details');
            $client->address = request('address');
            $client->contact_number = request('contact_number');
            $client->email = request('email');
            $client->company_url = request('company_url');
            $client->status = request('status');
            $client->first_contact_date = request('first_contact_date');
            // GET CHANGES
            $changes = $client->getDirty();
            // GET ORIGINAL DATA
            $this->function->getOldData($this->module,$string,$changes,$id);
            $client->update();
            // GET CHANGES
            $changed = $client->getChanges();
            // USE UPDATESYSTEMLOG FUNCTION
            $this->function->updateSystemLog($this->module,$changed,$string,$id);
            if ( $client->wasChanged() ) {
                return redirect('/hris/pages/admin/properties/clients/index')->with('success', $'Client successfully updated!');
            } else {
                return redirect('/hris/pages/admin/properties/clients/index');
            }
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_clients $client)
    {
        $id = $_SESSION['sys_id'];
        $upass = $this->function->decryptStr(users::find($id)->upass);
        if ( $upass == request('upass') ) {
            $client->delete();
            $id = $client->id;
            $this->function->deleteSystemLog($this->module,$id);
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

}
