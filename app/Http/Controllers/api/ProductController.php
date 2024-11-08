<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\Product;
use Illuminate\Container\Attributes\Storage;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //

    public function allProduct(){
        $product = Product::all();
        return response()->json([
            "status"=> "Succes",
            "message"=> "Product data fetched successfully",
            "data"=> $product
        ]);
    }

    public function showProduct(Request $request)
    {
        $business_id = $request->query('business_id'); 
    
        if (!$business_id) {
            return response()->json([
                "status" => "error",
                "message" => "business_id is required",
            ], 400);
        }
    
        $products = Product::with('businesses')->where('business_id', $business_id)->get();
    
        if ($products->isEmpty()) {
            return response()->json([
                "status" => "error",
                "message" => "No products found for this business",
            ], 404);
        }
    
        return response()->json([
            "status" => "success",
            "message" => "Products fetched successfully",
            "data" => $products
        ], 200);
    }
    
    
    public function createProduct(Request $request){
        $request->validate([
            'name' => 'required',
            'type' => 'required',
        ]);
        $user= $request->user();

        $check_business = Business::where("id", $request->business_id)->first();
        if($check_business->user_id != $user->id){
            return response(['status' => 'error', 'message' => 'Unauthorised Access'], 422);
        }
        $imagePath = null;
        if($request->hasFile('image_path')) {
            $imagePath = $request->file('image_path')->store('products', 'public'); 
        }
        $business = new Product(); 
        $business->user_id= $user->id;
        $business->business_id= $request->business_id;
        $business->name= $request->name;
        $business->price= $request->price;
        $business->image_path= $imagePath;
        $business->quantity= $request->quantity;
        $business->save();

        return response()->json([
            "status"=>"succes",
            "message"=>"Product successfully created",
            "data"=>$business
        ],200);

    }
    public function updateProduct(){

    }
}
