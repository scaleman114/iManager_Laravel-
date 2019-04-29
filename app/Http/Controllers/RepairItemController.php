<?php

namespace App\Http\Controllers;

use App\Repair;
use App\RepairItem;
use Illuminate\Http\Request;

class RepairItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $repair = Repair::find($id);
        return view('repairitems.create', compact('repair'));
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

        $repairitem = new RepairItem([
            'repair_id' => $request->get('repair_id'),
            'mc_type' => $request->get('mc_type'),
            'serial_no' => $request->get('serial_no'),
            'capacity' => $request->get('capacity'),

        ]);
        //dd($repairitem);
        $repairitem->save();
        return redirect('/repairs')->with('success', 'Repair Item has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RepairItem  $repairItem
     * @return \Illuminate\Http\Response
     */
    public function show(RepairItem $repairItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RepairItem  $repairItem
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $repairitem = RepairItem::find($id);

        //dd($repairitem);

        return view('repairitems.edit', compact('repairitem'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RepairItem  $repairItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'serial_no' => 'required',

        ]);

        $repairitem = RepairItem::find($id);
        //dd($repairItem);
        $repairitem->repair_id = $request->get('repair_id');
        $repairitem->mc_type = $request->get('mc_type');
        $repairitem->serial_no = $request->get('serial_no');
        $repairitem->capacity = $request->get('capacity');
        $repairitem->save();

        return redirect('/repairs/' . $repairitem->repair_id . '/edit')->with('success', 'Repair Item has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RepairItem  $repairItem
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $repairitem = repairitem::find($id);
        //dd($id);
        if ($repairitem != null) {
            $repairitem->delete();
            return redirect('/repairs')->with('success', 'Item has been deleted Successfully');
        }
        return redirect('/repairs')->with('ERROR', 'Wrong ID');
    }
}