<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Subscription;

class SubscriptionController extends Controller
{
    public function store($id, $amount){

        $currentDate= strtotime(date("Y-m-d"));
        $startDate = date("Y-m-d", strtotime("-2 month", $currentDate));
        $endDate = date("Y-m-d", strtotime("-1 month", $currentDate));

        $subscription = new Subscription();
        $subscription->user_id = $id;
        $subscription->amount = $amount;
        $subscription->start_date = $startDate;
        $subscription->end_date = $endDate;
        $subscription->save();

        return response()->json([
            "success" => $true
        ]);
    }

    public function checkSubscription(Request $request){

        $user = DB::table('subscriptions')->where('user_id', $request->input('user_id'))->get();
        $count = count($user);
        if($count>0){
            $endDate = strtotime($user[0]->end_date);
            $today = strtotime(date("Y-m-d"));
            if($endDate > $today){
                return response()->json([
                    "status"=>true
                ]);
            }else{
                return response()->json([
                    "status"=>false,    
                ]); 
            }
        }
        else{
            //create default subscription
            $id = $request->input('user_id');
            $amount = 400;
            $subscription = self::store($id, $amount);
            return response()->json([
                "status"=>false,    
            ]); 
        }
    }

    public function updateSubscription(Request $request){
        
        $todayStamp = strtotime(date("Y-m-d"));
        $today = date("Y-m-d", $todayStamp);
        $amount = $request->input('amount');
        if($amount == 400){
            $endDate = date("Y-m-d", strtotime("+1 month", $todayStamp)); 
        }else if($amount == 1000){
            $endDate = date("Y-m-d", strtotime("+3 month", $todayStamp)); 
        }

        $subscription = DB::update('update subscriptions set start_date = " '.$today.' ", end_date = " '.$endDate.' " where user_id = 4');
        
        return response()->json([
            "success"=> true
        ]); 
    }
}
