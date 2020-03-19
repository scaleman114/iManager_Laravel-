<?php

namespace App\Http\Controllers;

use App\Mail\RepairPDF;
use App\Repair;
use App\ZohoContact;
use Illuminate\Http\Request;
use PDF;

class RepairController extends Controller
{

    //this ensures you have to be logged on to access 'repairs'
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

        //Collection needs to be collectedaccessed without get to add pagination

        $repairs = Repair::search($searchTerm);

        return view('repairs.index', compact('repairs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $zohocontacts = ZohoContact::all(['customer_name']);
        return view('repairs.create', compact('zohocontacts'));
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
            'repair_customer' => 'required',

        ]);

        $zcontact = ZohoContact::where('customer_name', '=', $request->get('repair_customer'))->first();

        //dd($zcontact);
        $repair = new repair([
            'repair_customer' => $request->get('repair_customer'),
            'date' => $request->get('date'),
            'repair_type' => $request->get('repair_type'),
            'min_charge' => $request->get('min_charge'),
            'quoted' => $request->get('quoted'),
            'hours' => $request->input('hours'),
            'notes' => $request->get('notes'),
            'email' => $zcontact->customer_email,

        ]);
        //dd($repair);

        $repair->save();
        //now return to edit the repair
        return redirect('/repairs/' . $repair->id . '/edit')->with('success', 'Repair has been added');
        //return redirect('/repairs')->with('success', 'Repair has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Repair  $repair
     * @return \Illuminate\Http\Response
     */
    public function show(Repair $repair)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Repair  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $repair = repair::find($id);
        $zohocontacts = ZohoContact::all(['customer_name']);
        //dd($repair);
        $repairitems = $repair->repairitems;
        //dd($repairitems);
        return view('repairs.edit', compact('repair', 'zohocontacts', 'repairitems'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Repair  $repair
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'repair_customer' => 'required',

        ]);
        $input = $request->all();
        //dd($input);
        $repair = Repair::find($id);

        /* Much easier way of assigning request values than below, needs the correct fields set to fillable though */
        $repair->fill($input)->save();
        //dd($repair);

        //dd($input);

        /*   $repair = Repair::find($id);

        $repair->id = $request->get('repair_id');
        $repair->repair_customer = $request->get('repair_customer');

        $repair->date = $request->input('repair_date');
        $repair->min_charge = $request->input('min_charge');
        $repair->quoted = $request->input('quoted');
        $repair->hours = $request->input('hours');
        $repair->notes = $request->get('repair_notes');
        $repair->repair_type = $request->get('repair_type');

        $repair->save(); */

        return redirect('/repairs')->with('success', 'Repair has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Repair  $repair
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $repair = repair::find($id);
        //dd($id);
        if ($repair != null) {
            $repair->delete();
            return redirect('/repairs')->with('success', 'Repair has been deleted Successfully');
        }
        return redirect('/repairs')->with('ERROR', 'Wrong ID');
    }

    public function downloadPDF($id)
    {
        //Get the repair from the id
        $repair = Repair::find($id);
        //Get the zoho contact info & create an address
        $contact = zcontactfromname($repair->repair_customer);
        $address = $contact->customer_name . "\r\n" . $contact->address . "\r\n" . $contact->street2 . " " .
        $contact->city . ".\r\n" . $contact->state . "\r\n" . $contact->zip;
        //dd($address);
        //Get the repair items
        //$repairitems = RepairItem::repair($id)->get();
        $repairitems = $repair->repairitems;
        //dd($repairitems);
        //Create the pdf from the view
        $pdf = PDF::loadView('repairs.pdf', compact('repair', 'repairitems', 'address'));
        //Download the pdf
        return $pdf->download('repair_' . $id . '.pdf');

    }

    public function emailPDF(Request $request)
    {

        //Get the repair from the id
        $repair = Repair::find($request->get('repair_id'));
        $formEmail = $request->get('email');
        //Get the zoho contact info & create an address
        $contact = zcontactfromname($repair->repair_customer);
        $address = $contact->customer_name . "\r\n" . $contact->address . "\r\n" . $contact->street2 . " " .
        $contact->city . ".\r\n" . $contact->state . "\r\n" . $contact->zip;

        //Get the repair items
        $repairitems = $repair->repairitems;
        //Create the pdf from the view
        $pdf = PDF::loadView('repairs.pdf', compact('repair', 'repairitems', 'address'));

        //Setup $data array to hold the mail info
        $data["email"] = $formEmail;
        //if no email supplied use the default email in zoho
        if ($data["email"] == null) {
            $data["email"] = $contact->customer_email;
        }

        $data["client_name"] = $contact->customer_name;
        $data["subject"] = 'Repair Sheet ' . $repair->id;
        $data['pdf'] = $pdf->output();
        $data['pdf-name'] = 'Repair_' . $repair->id . '.pdf';
        //dd($data);

        //Build the mail message (/Mail/RepairPDF) as markdown
        try {
            \Mail::send(new RepairPDF($data));

        } catch (JWTException $exception) {
            $this->serverstatuscode = "0";
            $this->serverstatusdes = $exception->getMessage();
        }
        if (\Mail::failures()) {
            $this->statusdesc = "Error sending mail";
            $this->statuscode = "0";
            return redirect('/repairs')->with('error', $this->statusdesc);

        } else {

            $this->statusdesc = "Message sent succesfully to:" . $data["email"];
            $this->statuscode = "1";
            return redirect('/repairs')->with('success', $this->statusdesc);
        }

        return response()->json(compact('this'));

    }
}
