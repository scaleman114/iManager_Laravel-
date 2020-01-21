<?php

//require ‘vendor/autoload.php’;
use App\ZohoContact;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7;

/**
 * Return a contact from zoho contacts.
 *
 * @param  \App\ZohoContact  $id
 * @return \App\ZohoContact  $contact
 */
function zgetcontact($id)
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

        $res = $client->get(env('ZOHO_BOOKS_API') . '/contacts/' . $id, ['query' => $query, "headers" => $headers,
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
        //return the contact
        return $contact;
        //show the edit view
        //return view('zohocontacts.edit', compact('contact'));
    } catch (ClientException $e) {

        //unauthorised signin again
        if ($e->getCode() == 401) {
            exit('ERROR getting tokens: ' . $e->getMessage() . header('Location: ' . '/signin'));
        } else {
            exit('ERROR - Request was:' . Psr7\str($e->getRequest()) . ' - Response was:' . Psr7\str($e->getResponse()));
            //exit('ERROR: ' . $e->getCode());
        }
        return;

        //echo Psr7\str($e->getRequest());
        //echo Psr7\str($e->getResponse());
    }

}
/**
 * Return a contact from zoho contacts using name only.
 *
 * @param  \App\ZohoContact  $name
 * @return \App\ZohoContact  $contact
 */
function zcontactfromname($name)
{
    //Get the contact from the local database
    $zcontact = ZohoContact::where('customer_name', '=', ($name))->first();
    //Now fetch the contact from zoho using the Id
    $contact = zgetcontact($zcontact->contact_id);
    return $contact;
}
/**
 * Return a contact email from zoho contacts using name only.
 *
 * @param  \App\ZohoContact  $name
 * @return \App\ZohoContact  $email
 */
function zcontactemailfromname($name)
{
    //Get the contact from the local database
    $zcontact = ZohoContact::where('customer_name', '=', ($name))->first();
    //Now fetch the contact from zoho using the Id
    $contact = zgetcontact($zcontact->contact_id);
    return $contact->customer_email;
}