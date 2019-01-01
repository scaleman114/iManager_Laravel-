<?php

namespace App\Http\Controllers;
use App\Enquiry;
use Auth;
use DB;

use Illuminate\Http\Request;
use Carbon\Carbon;

class EnquiryController extends Controller
{
   
    
    //this ensures you have to be logged on to access 'enquiries'
    public function __construct()
    {
    $this->middleware('auth');
    }
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   /*  public function index()
    {
        //$enquiries = Enquiry::all();
        $enquiries = DB::table('enquiries')->where('enq_completed', '=', false)->get();

        return view('enquiries.index', compact('enquiries'));
    }*/

    public function index(Request $request) 
    {
        $searchTerm = $request->input('searchTerm');
        $isCleared = $request->input('isCleared');
        if($isCleared == null)
        $isCleared = 0;
        $enquiries = Enquiry::isCleared($isCleared)->search($searchTerm)->get();
        
        
        //dd($isCleared);
        /*if($searchTerm != null)
        $enquiries = Enquiry::search($searchTerm)->get();
        else
        $enquiries = Enquiry::isCleared($isCleared)->get();
      /*  else
        $enquiries = Enquiry::query('where', 'enquiries.enq_completed', '=', '0')->get();
        //dd($enquiries);*/
       
        return view('enquiries.index', compact('enquiries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('enquiries.create');
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
            'enq_customer'=>'required',
            'enq_description'=> 'required'
        ]);
        //$current = Carbon::now(); 
        $enquiry = new Enquiry([
            'enq_customer' => $request->get('enq_customer'),
            'enq_description'=> $request->get('enq_description'),
            'enq_completed'=> false,
            'enq_diarydate'=> $request->input('enq_diarydate'),
            'user_id'=> Auth::id(), //the logged on user
            'enq_contact' => $request->get('enq_contact')
            
          ]);
          //dd(Auth::id());
          $enquiry->save();
          return redirect('/enquiries')->with('success', 'Enquiry has been added');
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
        $enquiry = Enquiry::find($id);
        //dd($enquiry);

        return view('enquiries.edit', compact('enquiry'));
       
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
            'enq_customer'=>'required',
            'enq_description'=> 'required',
        
          ]);
    
          $enquiry = Enquiry::find($id);
          $enquiry->enq_customer = $request->get('enq_customer');
          $enquiry->enq_description = $request->get('enq_description');
          //$enquiry->enq_completed = $request->get('enq_completed');
          
          //get the value from checkbox - just need to set it to show checkbox checked
          if (!$request->input('enq_completed'))
            $enquiry->enq_completed = false;
            else
            $enquiry->enq_completed = true;
          //dd($enquiry->enq_completed);
          $enquiry->enq_diarydate = $request->input('enq_diarydate');
          $enquiry->user_id = Auth::id(); //the logged on user
          $enquiry->enq_contact = $request->get('enq_contact');
          //dd($request);
          $enquiry->save();
    
          return redirect('/enquiries')->with('success', 'Enquiry has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $enquiry = Enquiry::find($id);
        //dd($id);
        if($enquiry != null)
        {
        $enquiry->delete();
        return redirect('/enquiries')->with('success', 'Enquiry has been deleted Successfully');
        }
        return redirect('/enquiries')->with('ERROR', 'Wrong ID');
    }

    public function getdate(Request $request)
    {
        $datePeriod = $request->input('dateperiod');
        //dd($datePeriod);
        $enquiries = Enquiry::Diary($datePeriod)->get();
        //dd($enquiries);
        return view('enquiries.diary', compact('enquiries', 'datePeriod'));
    }


       
    
}
