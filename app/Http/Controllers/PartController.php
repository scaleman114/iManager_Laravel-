<?php

namespace App\Http\Controllers;

use App\Part;
use App\Group;
use Illuminate\Http\Request;

class PartController extends Controller
{
    
    //this ensures you have to be logged on to access 'parts'
    public function __construct()
    {
    $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $searchTerm = $request->input('searchTerm');
        $parts = Part::search($searchTerm)->get();
        return view('parts.index', compact('parts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $groups = Group::all();
        //dd($groups);
        return view('parts.create',compact('groups'));
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
            'description'=>'required',
            'price'=>'required',
            
          ]);
          $part = new Part([
            'description' => $request->get('description'),
            'cost'=> $request->get('cost'),
            'price'=> $request->get('price'),
            'count'=> $request->get('count'),
            'supplier_no'=> $request->get('supplier_no'),
            'notes'=> $request->get('notes'),
            'stock_item'=> $request->get('stock_item'),
            'supplier_id'=> $request->get('supplier_id'),
            'group_id'=> $request->get('group_id'),

          ]);
          $part->save();
          return redirect('/parts')->with('success', 'Part has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Part  $part
     * @return \Illuminate\Http\Response
     */
    public function show(Part $part)
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
        $part = Part::find($id); 
        $groups = Group::all();
        //dd($part); 
        return view('parts.edit', compact('part','groups'));
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
            'description'=>'required',
            'price'=>'required',
        ]);

        $part = part::find($id);
        
        $part->description = $request->get('description');
        $part->cost = $request->get('cost');
        $part->price = $request->get('price');
        $part->count = $request->get('count');
        $part->supplier_no = $request->get('supplier_no');
        $part->notes = $request->get('notes');
        //dd($request->stock_item);
        $stock = isset($request->stock_item[0]) ? 1 : 0;
        $part->stock_item = $stock;
        //dd($stock);
        //$part->stock_item = $request->get('stock_item');
        //
        $part->supplier_id = $request->get('supplier_id');
        $part->group_id = $request->get('group_id');
       // dd($request);
        $part->save();
        
        return redirect('/parts')->with('success', 'Part has been updated');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $part = Part::find($id);
        $part->delete();

        return redirect('/parts')->with('success', 'Part has been deleted');
    }
}