<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Contact::OrderBy('id','desc')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $contact = new Contact;
        $contact->create($request->all());
        /*$fields = $request->validate([
            'first_name' => 'required|string',
            'last_name'  => 'required|string',
            'phone'      => 'required',
            'address'    => 'required'
        ]);

        $contact = Contact::create([
            'first_name' => $fields['first_name'],
            'last_name'  => $fields['last_name'],
            'phone'      => $fields['phone'],
            'address'    => $fields['address']
        ]);*/

        /*return response()->json([
            'res' => 'Registro Agregado'
        ]);*/
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function show(Contact $contact)
    {
        return $contact;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contact $contact)
    {
        //
        //$contact->update($request->all());
        $fields = $request->validate([
            'first_name' => 'required|string',
            'last_name'  => 'required|string',
            'email'  => 'required|email',
            'phone'      => 'required',
            'address'    => 'required'
        ]);

        $contact->update([
            'first_name' => $fields['first_name'],
            'last_name'  => $fields['last_name'],
            'email'  => $fields['email'],
            'phone'      => $fields['phone'],
            'address'    => $fields['address']
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();

    }
}
