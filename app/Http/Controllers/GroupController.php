<?php

namespace App\Http\Controllers;

use App\Group;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = Group::all();
        //return $groups;
        return view('groups.index', compact('groups'));
    }

    public function fetchgroups($access_token)
    {
        $count = 0;
        $query = ([
            'organization_id' => env('OAUTH_ORGANIZATION_ID'),
            //'authtoken' => $access_token,
            //'Authorization' => 'Zoho-oauthtoken ' . $access_token,

        ]);
        //Add the headers
        $headers = ([
            'Authorization' => 'Zoho-authtoken ' . $access_token,
            'Content-type' => "application/json;charset=UTF-8",
            "cache-control" => "no-cache",

        ]);
        //dd($headers);
        try {
            $client = new Client();

            $res = $client->get(env('ZOHO_INV_API') . '/itemgroups', ['headers' => $headers, 'query' => $query,
            ]);
            //dd($res->getStatusCode());
            // $res = $client->get("https://inventory.zoho.com/api/v1/itemgroups?authtoken=5c55961c8385951c1aa091093cce49e2&organization_id=682542972");
            //$res = $client->get("https://inventory.zoho.com/api/v1/itemgroups", ['headers' => $headers,
            //    'query' => 'organization_id=682542972&authtoken=5c55961c8385951c1aa091093cce49e2']);

            //dd($res);
            $result = json_decode($res->getBody()->getContents(), true);
            //$hasmore = $result['page_context']['has_more_page'];
            //dd($hasmore);

            foreach ($result['itemgroups'] as $value) {
                $zgroup = new group;
                $zgroup->group_id = $value['group_id'];
                $zgroup->name = $value['group_name'];

                $zgroup->save();
                $count++;

            }

        } catch (ClientException $e) {

            exit('ERROR - Request was:' . Psr7\str($e->getRequest()) . ' - Response was:' . Psr7\str($e->getResponse()));

        }

        //return count and hasmore bool - has to be an array as 2 things returned
        return ($count);

    }

    //Gets all groups from zoho
    public function groups()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $access_token = env('ZOHO_INV_AUTHTOKEN');
        //dd($access_token);

        //Empty the table and reset the autoinc to 1
        Group::truncate();

        $totalloaded = 0;
        //Run the query for 4 pages, need to alter this at some point so it collects automatically.
        //for ($i = 1; $i < 5; $i++) {

        //$fetched is the returned array
        $count = $this->fetchgroups($access_token);

        //dd($morepages, $i);

        //}
        //echo 'Number of groups added = '.$totalloaded."<br>";

        $groups = group::all();
        //dd($groups);
        header('Location: ' . '/groups');
        //return view('zohogroups.index', compact('groups', 'totalloaded'));

        /*foreach ($result['groups'] as $value) {
        echo $value['customer_name']." ".$value['email']."<br>";

        }*/
        //echo $result['text']."\n";
        /* if ($result['page_context']['has_more_page']=='true')
        echo 'More pages'; */
        //dd($result);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('groups.create');
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
            'name' => 'required',

        ]);

        $group = new Group([
            'name' => $request->get('name'),
        ]);

        $group->save();
        self::zstore($group);
        return redirect('/groups')->with('success', 'Group has been added');
    }

    //create the group in zoho inventory - NB zoho will only allow creation if an item is added.
    private function zstore($group)
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        //The AccessToken
        $access_token = env('ZOHO_INV_AUTHTOKEN');

        $query = ([
            'organization_id' => env('OAUTH_ORGANIZATION_ID'),

        ]);
        //Add the headers
        $headers = ([
            'Authorization' => 'Zoho-authtoken ' . $access_token,
            'Content-type' => "application/x-www-form-urlencoded;charset=UTF-8",

        ]);

        $data = json_encode([
            'group_name' => $group->name,

        ]);

        //Jsonify contact body
        $body = ([
            'JSONString' => $data,
        ]);
        //dd($body);
        try {
            $client = new Client();

            $res = $client->post(env('ZOHO_INV_API') . '/itemgroups', ['query' => $query, "headers" => $headers,
                'form_params' => $body]);

        } catch (ClientException $e) {

            exit('ERROR - Request was:' . Psr7\str($e->getRequest()) . ' - Response was:' . Psr7\str($e->getResponse()));
            //exit('ERROR: ' . $e->getCode());

            return;

            //echo Psr7\str($e->getRequest());
            //echo Psr7\str($e->getResponse());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $group = Group::find($id);

        return view('groups.edit', compact('group'));
    }

    public function zedit($id)
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        //The AccessToken
        $access_token = env('ZOHO_INV_AUTHTOKEN');

        $query = ([
            'organization_id' => env('OAUTH_ORGANIZATION_ID'),

        ]);
        //Add the headers
        $headers = ([
            'Authorization' => 'Zoho-authtoken ' . $access_token,
            'Content-type' => "application/x-www-form-urlencoded;charset=UTF-8",

        ]);

        try {
            $client = new Client();

            $res = $client->get(env('ZOHO_INV_API') . '/itemgroups/' . $id, ['query' => $query, "headers" => $headers,
            ]);

            $result = json_decode($res->getBody()->getContents(), true);
            //get existing group from db
            $group = Group::where('group_id', $id)->first();
            //get the 'contact' array from the json result
            $data = $result['item_group'];
            //dd($data);
            //update the existing group in db
            $group->name = $data['group_name'];

            //save the existing group
            $group->save();

            //show the edit view
            return view('zohogroups.edit', compact('group'));
        } catch (ClientException $e) {

            exit('ERROR - Request was:' . Psr7\str($e->getRequest()) . ' - Response was:' . Psr7\str($e->getResponse()));
            //exit('ERROR: ' . $e->getCode());

            return;

            //echo Psr7\str($e->getRequest());
            //echo Psr7\str($e->getResponse());
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',

        ]);

        $group = Group::find($id);
        $group->name = $request->get('name');

        $group->save();

        self::zupdate($group);

        return redirect('/groups')->with('success', 'Group has been updated');
    }

    //update the group in zoho inventory - NB zoho will only allow update if items are added or it tries to delete them,
    //which it can't if they have trans against them.
    private function zupdate($group)
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        //The AccessToken
        $access_token = env('ZOHO_INV_AUTHTOKEN');

        $query = ([
            'organization_id' => env('OAUTH_ORGANIZATION_ID'),

        ]);
        //Add the headers
        $headers = ([
            'Authorization' => 'Zoho-authtoken ' . $access_token,
            'Content-type' => "application/x-www-form-urlencoded;charset=UTF-8",

        ]);

        $data = json_encode([
            'group_name' => $group->name,

        ]);

        //Jsonify contact body
        $body = ([
            'JSONString' => $data,
        ]);
        //dd($body);
        try {
            $client = new Client();

            $res = $client->put(env('ZOHO_INV_API') . '/itemgroups/' . $group->group_id, ['query' => $query, "headers" => $headers,
                'form_params' => $body]);

        } catch (ClientException $e) {

            exit('ERROR - Request was:' . Psr7\str($e->getRequest()) . ' - Response was:' . Psr7\str($e->getResponse()));
            //exit('ERROR: ' . $e->getCode());

            return;

            //echo Psr7\str($e->getRequest());
            //echo Psr7\str($e->getResponse());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $group = Group::find($id);
        //dd($id);
        if ($group != null) {
            $group->delete();
            return redirect('/enquiries')->with('success', 'Group has been deleted Successfully');
        }
        return redirect('/groups')->with('ERROR', 'Wrong ID');
    }
}