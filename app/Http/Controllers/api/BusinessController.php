<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Business;
use Illuminate\Http\Request;

class BusinessController extends Controller
{
    //

    public function __construct()
    {
       
    }
    public function allBusiness(Request $request){
        $businesses = Business::all();
        return response()->json([
            "status" => "success",
            "data" => $businesses
        ], 200);
    }
    public function createBusiness(Request $request){
        $request->validate([
            'name' => 'required',
            'type' => 'required',
            'starting_capital' => 'required|numeric',
        ]);
       $user= $request->user();

        $business = new Business();
        $business->user_id= $user->id;
        $business->name= $request->name;
        $business->type= $request->type;
        $business->gst_no= $request->gst_no;
        $business->alternate_number= $request->alternate_number;
        $business->address= $request->address;
        $business->starting_capital= $request->starting_capital;
        $business->save();

        return response()->json([
            "status"=>"succes",
            "message"=>"Business successfully created",
            "data"=>$business
        ],200);

    }
    public function updateBusiness(Request $request){

    }
}
