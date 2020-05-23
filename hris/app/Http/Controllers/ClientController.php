<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\hris_clients;

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
        $client->delete();
        return redirect('/hris/pages/admin/properties/clients/index')->with('success', 'Client successfully deleted!');
    }

    protected function validatedData()
    {
        return request()->validate([
            'name' => 'required',
            'status' => 'required'
        ]);
    }

}
