<?php

namespace App\Http\Controllers;

use App\Contract;
use App\ContractItem;
use App\ZohoContact;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    //this ensures you have to be logged on to access 'contracts'
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
        $contracts = Contract::all();
        return view('contracts.index', compact('contracts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $zohocontacts = ZohoContact::all(['customer_name']);
        return view('contracts.create', compact('zohocontacts'));
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
            'contract_customer' => 'required',

        ]);

        $zcontact = ZohoContact::where('customer_name', '=', $request->get('contract_customer'))->first();
        //dd($zcontact);
        $contract = new Contract([
            'contract_id' => $request->get('contract_id'),
            'contract_customer' => $request->get('contract_customer'),
            'contract_terms' => $request->get('contract_terms'),
            'contract_premium' => $request->get('contract_premium'),
            'contract_period' => $request->get('contract_period'),
            'contract_startdate' => $request->input('contract_startdate'),
            'contract_notes' => $request->get('contract_notes'),
            'contract_type' => $request->get('contract_type'),

        ]);
        //dd($contract);
        $contract->save();
        return redirect('/contracts')->with('success', 'Contract has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function show(Contract $contract)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $contract = contract::find($id);
        $zohocontacts = ZohoContact::all(['customer_name']);
        //dd($contract);
        $contractitems = ContractItem::Contract($id)->get();
        //dd($contractitems);
        return view('contracts.edit', compact('contract', 'zohocontacts', 'contractitems'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'contract_customer' => 'required',

        ]);

        $contract = contract::find($id);

        $contract->contract_id = $request->get('contract_id');
        $contract->contract_customer = $request->get('contract_customer');
        $contract->contract_premium = $request->get('contract_premium');
        $contract->contract_startdate = $request->input('contract_startdate');
        $contract->contract_terms = $request->get('contract_terms');
        $contract->contract_period = $request->get('contract_period');
        $contract->contract_notes = $request->get('contract_notes');
        $contract->contract_type = $request->get('contract_type');

        $contract->save();

        return redirect('/contracts')->with('success', 'Contract has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $contract = contract::find($id);
        //dd($id);
        if ($contract != null) {
            $contract->delete();
            return redirect('/contracts')->with('success', 'Contract has been deleted Successfully');
        }
        return redirect('/contracts')->with('ERROR', 'Wrong ID');
    }

    public function downloadPDF($id)
    {
        $contract = Contract::find($id);
        $pdf = PDF::loadView('contracts.pdf', compact('contract'));
        return $pdf->download('contract.pdf');

    }
}