<?php

namespace App\Http\Controllers;

use App\Contract;
use App\ContractItem;
use Illuminate\Http\Request;

class ContractItemsController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $contract = Contract::find($id);
        return view('contractitems.create', compact('contract'));
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
            'serial_no' => 'required',

        ]);

        $contractitem = new ContractItem([
            'contract_id' => $request->get('contract_id'),
            'mc_type' => $request->get('mc_type'),
            'serial_no' => $request->get('serial_no'),
            'capacity' => $request->get('capacity'),

        ]);
        //dd($contract);
        $contractitem->save();
        return redirect('/contracts')->with('success', 'Contract Item has been added');
    }
}