<?php

namespace App\Http\Controllers;

use App\Transporter;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Config;


class TransporterController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('users')->where('user_type', '1')->get();
	    $count = count($query);
        $transporters = [];

        if ($count > 0){
             for($i=0; $i<$count;$i++){
                 $transporters[$i] = $query[$i];	
             }
        } 

    
        return response()->json([
            "success" => true,
            "transporters" => $transporters
        ]);

    }


    public function searchUser(Request $request)
    {
        $user = DB::table('users')->where('email', $request->input('email'))->get();
        return response()->json([
            "user" => $user
        ]);

    }

    public function store(Request $request)
    {
        $email =$request->input('email');
        $update =  DB::update('update users set user_type = "1" where email = ?',[$email]);

        $region = $request->input('region');
        $site = serialize(Config::get('constants.regions.'.$region.'.Dump Site'));

        if ($update == true){
           $transporter = new Transporter();
           $transporter-> user_id = $request->input('user_id')  ;
           $transporter-> email = $request->input('email');
           $transporter-> region = $request->input('region');
           $transporter-> site_address = $site;
           $transporter->save();
            return response()->json([
                "transporter" => $transporter
            ]);
        }else{
            return response()->json([
                "error" => "user already transporter"
            ]);
        }

    }


    public function show($id)
    {

    }


    public function edit($id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}
