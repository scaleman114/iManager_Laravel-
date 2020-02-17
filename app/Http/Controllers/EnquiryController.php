<?php

namespace App\Http\Controllers;

use App\Enquiry;
use App\Http\Controllers\Notification;
use App\Notifications\NewEnquiryAlert;
use App\User;
use App\ZohoContact;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PDF;

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
        //$homeurl = Storage::url('home.png');
        //dd($url);
        $searchTerm = $request->input('searchTerm');
        $isCleared = $request->input('isCleared');
        if ($isCleared == null) {
            $isCleared = 0;
        }

        $enquiries = Enquiry::isCleared($isCleared)
            ->search($searchTerm)
            ->orderby('updated_at', 'desc')
            ->get();

        //dd($enquiries);
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
        $zohocontacts = ZohoContact::all(['customer_name']);
        return view('enquiries.create', compact('zohocontacts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Enquiry $enquiry
     * @return \Illuminate\Http\Response
     */
    //public function store(Request $request)
    public function store(Enquiry $enquiry)
    {
        request()->validate([
            'enq_zcontact' => 'required',
            'enq_description' => 'required',
        ]);
        $zcontact = ZohoContact::where('customer_name', '=', request('enq_zcontact'))->first();
        $enquiry->create([
            'enq_customer' => request('enq_zcontact'),
            'enq_description' => request('enq_description'),
            'enq_diarydate' => request('enq_diarydate'),
            'enq_email' => $zcontact->customer_email,
            'enq_phone' => $zcontact->customer_phone,
            'user_id' => Auth::id(), //the logged on user

        ]);

        //Send a notification to all users
        $users = User::select("email")->get();
        //dd($users);

        try {
            \Notification::send($users, new NewEnquiryAlert($enquiry));
        } catch (\Exception $e) {
            return redirect('/enquiries')->with('success', 'Enquiry has been added but notification failed');
        }

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
        $zohocontacts = ZohoContact::all(['customer_name']);
        //dd($enquiry);

        return view('enquiries.edit', compact('enquiry', 'zohocontacts'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Enquiry $enquiry
     * @return \Illuminate\Http\Response
     */
    public function update(Enquiry $enquiry)
    {
        request()->validate([
            'enq_zcontact' => 'required',
            'enq_description' => 'required',

        ]);

        $zcontact = ZohoContact::where('customer_name', '=', request('enq_zcontact'))->first();

        if (!request('enq_completed')) {
            $enquiry->enq_completed = false;
        } else {
            $enquiry->enq_completed = true;
        }
        $enquiry->update([
            'enq_customer' => request('enq_zcontact'),
            'enq_description' => request('enq_description'),
            'enq_diarydate' => request('enq_diarydate'),
            'enq_email' => $zcontact->customer_email,
            'enq_phone' => $zcontact->customer_phone,
            'user_id' => Auth::id(), //the logged on user

        ]);

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
        if ($enquiry != null) {
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

        $empty = true;
        foreach ($enquiries as $el) {
            if ($el) {
                $empty = false;
                break;
            }
        }
        if ($empty) {
            return redirect('/enquiries')->with('ERROR', 'No Alerts');
        } else {
            return view('enquiries.diary', compact('enquiries', 'datePeriod'));
        }

    }

    public function downloadPDF($id)
    {
        $enquiry = Enquiry::find($id);
        $pdf = PDF::loadView('enquiries.pdf', compact('enquiry'));
        return $pdf->download('enquiry.pdf');

    }

}
