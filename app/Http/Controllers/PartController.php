<?php

namespace App\Http\Controllers;

use App\Group;
use App\Part;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7;
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

    public function fetchParts($i, $access_token)
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
        //dd($headers);
        try {
            $client = new Client();
            //$res = $client->get("https://books.zoho.com/api/v3/items", ['query' => $query, "headers" => $headers]);

            $res = $client->get(env('ZOHO_INV_API') . '/items', ['query' => $query, "headers" => $headers]);
            //dd($res);
            $result = json_decode($res->getBody()->getContents(), true);
            //dd($result);
            $status = $result['code'];
            $hasmore = $result['page_context']['has_more_page'];
            //dd($hasmore);
            //dd($result);
            foreach ($result['items'] as $value) {
                //dd($value);
                $zpart = new Part;
                $zpart->part_id = $value['item_id'];
                $zpart->sku = $value['sku'];
                $zpart->description = $value['name'];
                $zpart->price = $value['rate'];
                $zpart->cost = $value['purchase_rate'];
                $zpart->notes = $value['description'];
                if (array_key_exists('stock_on_hand', $value)) {
                    $zpart->count = $value['stock_on_hand'];
                }
                if ($value['item_type'] == 'inventory') {
                    $zpart->stock_item = 1;
                } else {
                    $zpart->stock_item = 0;
                }
                if (array_key_exists('group_id', $value)) {

                    $zpart->group_id = $value['group_id'];
                }

                $zpart->save();
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
        //return count and hasmore bool - has to be an array as 2 things returned
        return array($count, $hasmore, $status);

    }

    //Gets all parts from zoho route '/zohoparts'
    public function parts()
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
        Part::truncate();

        $totalloaded = 0;
        //Run the query for 4 pages, need to alter this at some point so it collects automatically.
        //for ($i = 1; $i < 5; $i++) {
        $i = 1;
        $morepages = true;
        while ($morepages == true) {
            //$fetched is the returned array
            $fetched = $this->fetchParts($i, $access_token);
            $totalloaded += $fetched[0];
            $morepages = $fetched[1];
            $i++;
            //dd($morepages, $i);

        }

        //}
        //echo 'Number of parts added = '.$totalloaded."<br>";

        $parts = Part::all();
        //dd($parts);
        //header('Location: ' . '/parts');
        //dd($fetched);
        //if no error
        if ($fetched[2] == 0) {
            return redirect('/parts')->with('success', 'Zoho parts updated');
        } else {
            return redirect('/parts')->with('error', 'Error:' . $fetched[2]);
        }
        //return view('zohoparts.index', compact('parts', 'totalloaded'));

        /*foreach ($result['parts'] as $value) {
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
        $groups = Group::all();
        //dd($groups);
        return view('parts.create', compact('groups'));
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
            'description' => 'required',
            'price' => 'required',

        ]);
        $part = new Part([
            'sku' => $request->get('sku'),
            'description' => $request->get('description'),
            'cost' => $request->get('cost'),
            'price' => $request->get('price'),
            'count' => $request->get('count'),
            'supplier_no' => $request->get('supplier_no'),
            'notes' => $request->get('notes'),
            'stock_item' => $request->get('stock_item'),
            'supplier_id' => $request->get('supplier_id'),
            'group_id' => $request->get('group_id'),

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
        return view('parts.edit', compact('part', 'groups'));
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
            'description' => 'required',
            'price' => 'required',
        ]);

        $part = part::find($id);
        $part->sku = $request->get('sku');
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
        self::zupdate($part);
        return redirect('/parts')->with('success', 'Part has been updated');

    }

    //update the contact in zoho books
    private function zupdate($part)
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

        //dd($contactPerson);
        $data = json_encode([
            'name' => $part->description,
            'rate' => $part->price,
            'purchase_rate' => $part->cost,
            'description' => $part->notes,
            'sku' => $part->sku,
            'group_id' => $part->group_id,

        ]);

        /*   $data2 = json_encode([

        'contact_persons' => $contactPerson,
        ]);*/

        //Jsonify contact body
        $body = ([
            'JSONString' => $data,
        ]);

        //dd($body);
        //dd($zcontact->primary_contactId);
        try {
            $client = new Client();
            //Send to items
            $res = $client->put(env('ZOHO_INV_API') . '/items/' . $part->part_id,
                ['query' => $query, "headers" => $headers, 'form_params' => $body]);

            //dd($res);
        } catch (ClientException $e) {
            //unauthorised
            if ($e->getCode() == 401) {
                exit('ERROR getting tokens: ' . $e->getMessage() . header('Location: ' . '/signin'));
            } else {
                exit('ERROR - Request was:' . Psr7\str($e->getRequest()) . ' - Response was:' . Psr7\str($e->getResponse()));
                //exit('ERROR: ' . $e->getCode());
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