<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use App\Contact;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($customer_id)
    {
        $contacts = Customer::find($customer_id)->contacts;
        return view('contacts.index', compact('contacts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($customer_id)
    {
        //dd($customer_id);
        return view('contacts.create',compact('customer_id'));
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'contact_name'=>'required',
            
          ]);
          $contact = new Contact([
            'contact_name' => $request->get('contact_name'),
            'job_title'=> $request->get('job_title'),
            'phone'=> $request->get('phone'),
            'ext'=> $request->get('ext'),
            'mobile'=> $request->get('mobile'),
            'email'=> $request->get('email'),
            
           ]);
           $contact->customer_id = $request->get('customer_id');
           //dd($contact);
          $contact->save();
          $customer = $contact->customer;
        //$customer = Customer::find($contact->customer_id);
        $contacts = $customer->contacts;
      
        return view('customers.edit', compact('customer','contacts'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $contact = Contact::find($id);

        return view('contacts.edit', compact('contact'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'contact_name'=>'required',
        ]);

        $contact = Contact::find($id);
        
        $contact->contact_name = $request->get('contact_name');
        $contact->job_title = $request->get('job_title');
        $contact->phone = $request->get('phone');
        $contact->ext = $request->get('ext');
        $contact->mobile = $request->get('mobile');
        $contact->email = $request->get('email');
        
        $contact->save();
        
        $customer = $contact->customer;
        //$customer = Customer::find($contact->customer_id);
        $contacts = $customer->contacts;
      
        return view('customers.edit', compact('customer','contacts'));
        //return redirect('/customers')->with('success', 'Contact has been updated');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $contact = Contact::find($id);
        $contact->delete();
        $customer = $contact->customer;
        //$customer = Customer::find($contact->customer_id);
        $contacts = $customer->contacts;
      
        return view('customers.edit', compact('customer','contacts'));
    }
}