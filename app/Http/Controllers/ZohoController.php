<?php

namespace App\Http\Controllers;

use App\ZohoContact;
//require ‘vendor/autoload.php’;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

//use GuzzleHttp\Psr7\Request;

class ZohoController extends Controller
{
    //this ensures you have to be logged on to access 'zohocontacts'
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $contacts = ZohoContact::all();
        //return $groups;
        return view('zohocontacts.index', compact('contacts'));
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
                $zcontact->save();
                $count++;

            }

        } catch (\Exception $e) {

            //exit('ERROR getting tokens: '.$e->getMessage());
            //if there is an error chances are you need to sign in again so let's go there

            exit('ERROR getting tokens: ' . $e->getMessage() . header('Location: ' . '/signin'));
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
        //return $groups;
        return view('zohocontacts.index', compact('contacts', 'totalloaded'));

        /*foreach ($result['contacts'] as $value) {
        echo $value['customer_name']." ".$value['email']."<br>";

        }*/
        //echo $result['text']."\n";
        /* if ($result['page_context']['has_more_page']=='true')
        echo 'More pages'; */
        //dd($result);

    }

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
            //get existing contact rom db
            $contact = ZohoContact::where('contact_id', $id)->first();
            //get the 'contact' array from the json result
            $data = $result['contact'];
            //dd($data);
            //update the existing contact
            $contact->customer_name = $data['contact_name'];
            $contact->address = $data['billing_address']['address'];
            $contact->street2 = $data['billing_address']['street2'];
            $contact->city = $data['billing_address']['city'];
            $contact->state = $data['billing_address']['state'];
            $contact->zip = $data['billing_address']['zip'];
            //save the existing contact
            $contact->save();

            //show the edit view
            return view('zohocontacts.edit', compact('contact'));
        } catch (Exception $e) {

            //exit('ERROR getting tokens: '.$e->getMessage());
            //if there is an error chances are you need to sign in again so let's go there
            return $e->getMessage();

            //exit('ERROR getting tokens: '.$e->getMessage().header('Location: '.'/signin'));
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

        //Add the body
        $data = json_encode(['contact_name' => $zcontact->customer_name,
        ]);

        $body = ([
            'JSONString' => $data,
        ]);
        try {
            $client = new Client();

            $res = $client->put("https://books.zoho.com/api/v3/contacts/" . $zcontact->contact_id,
                ['query' => $query, "headers" => $headers, 'form_params' => $body]);

        } catch (Exception $e) {

            //exit('ERROR getting tokens: '.$e->getMessage());
            //if there is an error chances are you need to sign in again so let's go there
            return $e->getMessage();

            //exit('ERROR getting tokens: '.$e->getMessage().header('Location: '.'/signin'));
        }

    }

}