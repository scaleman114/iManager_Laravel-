<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;

class CustomerController extends Controller
{
    
    public function __construct()
    {
    $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::all();

        return view('customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('customers.create');
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
            'cust_name'=>'required',
            
          ]);
          $customer = new Customer([
            'cust_name' => $request->get('cust_name'),
            'address'=> $request->get('address'),
            'main_phone'=> $request->get('main_phone'),
            'main_email'=> $request->get('main_email'),
            'vatno'=> $request->get('vatno')
          ]);
          $customer->save();
          return redirect('/customers')->with('success', 'Customer has been added');
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
        $customer = Customer::find($id);

        return view('customers.edit', compact('customer'));
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
            'cust_name'=>'required',
        ]);

        $customer = Customer::find($id);
        
        $customer->cust_name = $request->get('cust_name');
        $customer->address = $request->get('address');
        $customer->main_phone = $request->get('main_phone');
        $customer->main_email = $request->get('main_email');
        $customer->vatno = $request->get('vatno');
        $customer->save();
        
        return redirect('/customers')->with('success', 'Customer has been updated');

          
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = Customer::find($id);
        $customer->delete();

        return redirect('/customers')->with('success', 'Customer has been deleted');
    }
}
