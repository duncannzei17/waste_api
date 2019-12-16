<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Collection;

class CollectionController extends Controller
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $userID = $request->input('user_id');
        $location = DB::table('locations')->where('user_id', $userID )->get();

        $collection = new Collection();
        $collection->schedule_id = $request->input('schedule_id');
        $collection->user_id = $userID;
        $collection->address = $location[0]->address;
        $collection->region = $location[0]->region;
        $collection->save();

        return response()->json([
            "resp" => $collection
        ]);
    }

    
    public function show(Request $request)
    {
        $id = $request->input('schedule_id');
       // $query = DB::select("SELECT * FROM collections WHERE  schedule_id = '".$id."' ");
    //    DB::table('users')->join('transporters','users.id','=','transporters.user_id')
    //             ->where('user_type', '1')->get();
        $query = DB::table('collections')->join('users','collections.user_id','=','users.id')
                   ->where('schedule_id', $id)->get();
        $count = count($query);
        $collections = [];

        if ($count > 0){
             for($i=0; $i<$count;$i++){
                 $coordinates = unserialize($query[$i]->address);
                 $lat = $coordinates['latitude'];
                 $long = $coordinates['longitude'];
                 $collections[$i]['firstName'] = $query[$i]->firstName;
                 $collections[$i]['lastName'] = $query[$i]->lastName;
                 $collections[$i]['phone'] = $query[$i]->phone;
                 $collections[$i]['region'] = $query[$i]->region;
                 $collections[$i]['latitude'] = $lat;
                 $collections[$i]['longitude'] = $long;
                // $collections[$i] = $query[$i];    
             }
        } 

        return response()->json([
            "collections" => $collections
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
