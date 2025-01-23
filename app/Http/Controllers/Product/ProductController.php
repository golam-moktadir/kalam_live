<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller{    

    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        return view('products.product_info');
    }

    public function productList(Request $request){
        $data = Product::select(['product_id', 'product_name', 'whole_sale', 'retail']); 
        return datatables()->of($data)->make(true);
    }

    public function addProduct(Request $request){
        $validator = Validator::make($request->all(), [
            'product_name' => 'required|string|max:150|unique:products',
            'whole_sale'   => 'required|numeric|max:9999',
            'retail'  => 'required|numeric|max:9999'
        ]);

        if($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        DB::beginTransaction();

        try{
            $product = new Product();
            $product->product_name  = $request->product_name;
            $product->whole_sale    = $request->whole_sale;
            $product->retail        = $request->retail;
            $product->save();

            DB::commit();
            return response()->json(['success' => 'Save Successful !']);
        } 
        catch (Exception $e){
            DB::rollBack();
            return response()->json(['error' => 'Save Faild !']);
        }
    }

    public function updateProduct(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'product_name' => 'required|string|max:150',
            'whole_sale'   => 'required|numeric|max:9999',
            'retail'  => 'required|numeric|max:9999'
        ]);

        if($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        DB::beginTransaction();

        try{
            $product = Product::find($id);
            $product->product_name  = $request->product_name;
            $product->whole_sale    = $request->whole_sale;
            $product->retail        = $request->retail;
            $product->save();

            DB::commit();
            return response()->json(['success' => 'Save Successful !']);
        } 
        catch (Exception $e){
            DB::rollBack();
            return response()->json(['error' => 'Save Faild !']);
        }
    }

    public function productDelete($id){
        DB::beginTransaction();

        try{
            $product = Product::find($id);
            $product->delete();

            DB::commit();
            return response()->json(['success' => 'Delete Successful !']);
        } 
        catch (Exception $e){
            DB::rollBack();
            return response()->json(['error' => 'Delete Faild !']);
        }
    }
}
