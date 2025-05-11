<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product\Product;
use App\Models\Inventory\OpeningBalance;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OpeningBalanceController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }

   public function index(){
      $products = Product::orderBy('product_id', 'desc')->get();
      return view('inventory.product_opening_balance', ['products' => $products]);
   }

   public function openingBalanceList(Request $request){
      $data = OpeningBalance::with('product')->select(['trans_id', 'trans_date', 'svc_qty', 'product_price', 'total_price', 'product_id']); 

      return datatables()->of($data)
         ->addColumn('product_name', function ($row) {
              return $row->product ? $row->product->product_name : '';
         })
         // ->editColumn('trans_date', function ($row){
         //    return Carbon::parse($row->trans_date)->format('d/m/Y'); 
         // })
         ->make(true);
   }

   public function addOpeningBalance(Request $request){
      $validator = Validator::make($request->all(), [
         'product_id'   => 'required|integer',
         'opening_date' => 'required',
         'product_qty'  => 'required|numeric|max:9999',
         'product_price' => 'required|numeric|max:999999',
         'total_price' => 'required|numeric|max:999999'
      ]);

      if($validator->fails()) {
         return response()->json(['errors' => $validator->errors()]);
      }

      DB::beginTransaction();

      try{
         $row = new OpeningBalance();
         $row->trans_type = 'O'; 
         $row->trans_date = $request->opening_date;
         $row->product_id  = $request->product_id;
         $row->svc_qty     = $request->product_qty;
         $row->product_price = $request->product_price;
         $row->total_price = $request->total_price;
         $row->added_on    = date('Y-m-d H:i:s');
         $row->added_by    = auth()->id();
         $row->save();

         DB::commit();
         return response()->json(['success' => 'Save Successful !']);
      } 
      catch (Exception $e){
         DB::rollBack();
         return response()->json(['error' => 'Save Faild !']);
      }
   }

   public function updateOpeningBalance(Request $request, $id){
      $validator = Validator::make($request->all(), [
         'product_id'   => 'required|integer',
         'opening_date' => 'required',
         'product_qty'  => 'required|numeric|max:9999',
         'product_price' => 'required|numeric|max:999999',
         'total_price' => 'required|numeric|max:999999'
      ]);

      if($validator->fails()) {
         return response()->json(['errors' => $validator->errors()]);
      }

      DB::beginTransaction();

      try{
         $row = OpeningBalance::find($id); 
         $row->trans_date = $request->opening_date;
         $row->product_id  = $request->product_id;
         $row->svc_qty     = $request->product_qty;
         $row->product_price = $request->product_price;
         $row->total_price  = $request->total_price;
         $row->edited_on    = date('Y-m-d H:i:s');
         $row->edited_by    = auth()->id();
         $row->save();

         DB::commit();
         return response()->json(['success' => 'Save Successful !']);
      } 
      catch (Exception $e){
         DB::rollBack();
         return response()->json(['error' => 'Save Faild !']);
      }
   }
}
