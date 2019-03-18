<?php

namespace App\Http\Controllers;

use App\ZohoContact;
//require ‘vendor/autoload.php’;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7;
use Illuminate\Http\Request;

class ZohoController extends Controller
{
    //this ensures you have to be logged on to access 'zohocontacts'
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {

        $searchTerm = $request->input('searchTerm');
        $contacts = ZohoContact::search($searchTerm)->get();
        return view('zohocontacts.index', compact('contacts'));
        /*$contacts = ZohoContact::all();
    //return $groups;
    return view('zohocontacts.index', compact('contacts'));*/
    }

    public function fetchContacts($i, $access_token)
    {
        $count = 0;
        $query = ([
            'organization_id' => env('OAUTH_ORGANIZATION_ID'),
            'page' => $i,
            'per_page' => 200,

        ]);
        //Add the headers
        $headers = ([
            'Authorization' => 'Zoho-oauthtoken ' . $access_token,
            'Content-type' => "application/x-www-form-urlencoded;charset=UTF-8",

        ]);
        try {
            $client = new Client();

            $res = $client->get("https://books.zoho.com/api/v3/contacts", ['query' => $query, "headers" => $headers,
            ]);

            $result = json_decode($res->getBody()->getContents(), true);

            //dd($result);

            foreach ($result['contacts'] as $value) {
                $zcontact = new ZohoContact;
                $zcontact->contact_id = $value['contact_id'];
                $zcontact->customer_name = $value['customer_name'];
                $zcontact->customer_email = $value['email'];
                $zcontact->customer_phone = $value['phone'];
                $zcontact->first_name = $value['first_name'];
                $zcontact->last_name = $value['last_name'];
                $zcontact->save();
                $count++;

            }

        } catch (ClientException $e) {
            //unauthorised
            if ($e->getCode() == 401) {
                exit('ERROR getting tokens: ' . $e->getMessage() . header('Location: ' . '/signin'));
            }

            echo Psr7\str($e->getRequest());
            echo Psr7\str($e->getResponse());
        }
        //echo $count."<br>";
        return $count;

    }
    //Gets all contacts from zoho
    public function contacts()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        //Create new instance of TokenCache
        $tokenCache = new \App\TokenStore\TokenCache;

        //$tokenCache->clearTokens();
        //echo 'Token: '.$tokenCache->getAccessToken();
        //dd($tokenCache->getAccessToken());
        $access_token = $tokenCache->getAccessToken();
        //dd($access_token);

        //Empty the table and reset the autoinc to 1
        ZohoContact::truncate();

        $totalloaded = 0;
        //Run the query for 4 pages, need to alter this at some point so it collects automatically.
        for ($i = 1; $i < 5; $i++) {

            $totalloaded += $this->fetchContacts($i, $access_token);

        }
        //echo 'Number of contacts added = '.$totalloaded."<br>";

        $contacts = ZohoContact::all();
        //dd($contacts);
        header('Location: ' . '/contacts');
        //return view('zohocontacts.index', compact('contacts', 'totalloaded'));

        /*foreach ($result['contacts'] as $value) {
        echo $value['customer_name']." ".$value['email']."<br>";

        }*/
        //echo $result['text']."\n";
        /* if ($result['page_context']['has_more_page']=='true')
        echo 'More pages'; */
        //dd($result);

    }
    //Don't think this function is used, uses zedit instead
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $contact = ZohoContact::find($id);
        //dd($contact);
        return view('zohocontacts.edit', compact('contact'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function zedit($id)
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        //Create new instance of TokenCache
        $tokenCache = new \App\TokenStore\TokenCache;

        //$tokenCache->clearTokens();
        //echo 'Token: '.$tokenCache->getAccessToken();
        //dd($tokenCache->getAccessToken());
        $access_token = $tokenCache->getAccessToken();
        $query = ([
            'organization_id' => env('OAUTH_ORGANIZATION_ID'),

        ]);
        //Add the headers
        $headers = ([
            'Authorization' => 'Zoho-oauthtoken ' . $access_token,
            'Content-type' => "application/x-www-form-urlencoded;charset=UTF-8",

        ]);

        try {
            $client = new Client();

            $res = $client->get("https://books.zoho.com/api/v3/contacts/" . $id, ['query' => $query, "headers" => $headers,
            ]);

            $result = json_decode($res->getBody()->getContents(), true);
            //get existing contact from db
            $contact = ZohoContact::where('contact_id', $id)->first();
            //get the 'contact' array from the json result
            $data = $result['contact'];
            //dd($data);
            //update the existing contact in db
            $contact->customer_name = $data['contact_name'];
            //email and phone come from listing when it is refreshed
            $contact->address = $data['billing_address']['address'];
            $contact->street2 = $data['billing_address']['street2'];
            $contact->city = $data['billing_address']['city'];
            $contact->state = $data['billing_address']['state'];
            $contact->zip = $data['billing_address']['zip'];
            $contact->primary_contactId = $data['primary_contact_id'];
            //$contact->first_name = $data['first_name'];
            //$contact->last_name = $data['last_name'];
            //save the existing contact
            $contact->save();

            //show the edit view
            return view('zohocontacts.edit', compact('contact'));
        } catch (ClientException $e) {

            //unauthorised signin again
            if ($e->getCode() == 401) {
                exit('ERROR getting tokens: ' . $e->getMessage() . header('Location: ' . '/signin'));
            } else {
                exit('ERROR: ' . $e->getCode());
            }
            return;

            //echo Psr7\str($e->getRequest());
            //echo Psr7\str($e->getResponse());
        }

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
            'customer_name' => 'required',

        ]);

        $contact = ZohoContact::find($id);
        //dd($contact);
        $contact->customer_name = $request->get('customer_name');
        $contact->customer_email = $request->get('email');
        $contact->customer_phone = $request->get('phone');
        $contact->address = $request->get('address');
        $contact->street2 = $request->get('street2');
        $contact->city = $request->get('city');
        $contact->zip = $request->get('zip');
        $contact->state = $request->get('state');
        $contact->first_name = $request->get('first');
        $contact->last_name = $request->get('last');
        //dd($contact);
        $contact->save();
        //send to zoho
        self::zupdate($contact);

        return redirect('/contacts')->with('success', 'Zoho Contact has been updated');
    }
    //update the contact in zoho books
    private function zupdate($zcontact)
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        //Create new instance of TokenCache
        $tokenCache = new \App\TokenStore\TokenCache;

        //$tokenCache->clearTokens();
        //echo 'Token: '.$tokenCache->getAccessToken();
        //dd($tokenCache->getAccessToken());
        $access_token = $tokenCache->getAccessToken();
        $query = ([
            'organization_id' => env('OAUTH_ORGANIZATION_ID'),

        ]);
        //Add the headers
        $headers = ([
            'Authorization' => 'Zoho-oauthtoken ' . $access_token,
            'Content-type' => "application/x-www-form-urlencoded;charset=UTF-8",

        ]);

        //Add the contact body
        $billingAddress = ([
            'address' => $zcontact->address,
            'street2' => $zcontact->street2,
            'city' => $zcontact->city,
            'state' => $zcontact->state,
            'zip' => $zcontact->zip,
        ]);
        //dd($billingAddress);
        //Add the contact person body - needs to be separate as we only alter primary contact person
        //and that's the first_name, last_name, email and phone that is included in the contact
        $contactPerson = json_encode(['email' => $zcontact->customer_email,
            'phone' => $zcontact->customer_phone,
            'first_name' => $zcontact->first_name,
            'last_name' => $zcontact->last_name,

        ]);

        //dd($contactPerson);
        $data = json_encode([
            'contact_name' => $zcontact->customer_name,
            'billing_address' => $billingAddress,

        ]);

        /*   $data2 = json_encode([

        'contact_persons' => $contactPerson,
        ]);*/

        //Jsonify contact body
        $body = ([
            'JSONString' => $data,
        ]);
        //dd($body);
        //Jsonify contact person body
        $body2 = ([
            'JSONString' => $contactPerson,
        ]);
        //dd($body2);
        //dd($zcontact->primary_contactId);
        try {
            $client = new Client();
            //Send to contacts
            $res = $client->put("https://books.zoho.com/api/v3/contacts/" . $zcontact->contact_id,
                ['query' => $query, "headers" => $headers, 'form_params' => $body]);
            //Send to contact persons
            $res = $client->put("https://books.zoho.com/api/v3/contacts/contactpersons/" . $zcontact->primary_contactId,
                ['query' => $query, "headers" => $headers, 'form_params' => $body2]);

            //dd($res);
        } catch (ClientException $e) {
            //unauthorised
            if ($e->getCode() == 401) {
                exit('ERROR getting tokens: ' . $e->getMessage() . header('Location: ' . '/signin'));
            } else {
                exit('ERROR: ' . $e->getCode());
            }
            return;
            //exit($e->getCode());
            //return $e->getCode();
            //dd($e->getCode());
            //echo $e->getCode();

            //echo Psr7\str($e->getRequest());
            //echo Psr7\str($e->getResponse());
        }

    }

}