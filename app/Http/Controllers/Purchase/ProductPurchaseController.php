<?php

namespace App\Http\Controllers\Purchase;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Purchase\ProductPurchase;
use App\Models\Purchase\ProductPurchaseDetail;
use App\Models\Supplier\Supplier;
use App\Models\Product\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProductPurchaseController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }

   public function index(){
      return view('purchase.product_purchase_info');
   }

   public function productPurchaseList(Request $request){
      $data = ProductPurchase::with('supplier')->select('purchase_id', 'purchase_no', 'purchase_date', 'supplier_id')->orderBy('purchase_id', 'desc');

      return datatables()->of($data)
         ->addColumn('supplier_name', function ($row) {
              return $row->supplier ? $row->supplier->supplier_name : '';
         })
         ->editColumn('purchase_date', function ($row){
            return Carbon::parse($row->purchase_date)->format('d/m/Y'); 
         })->make(true);
   }

   public function productPurchaseNew(){
      $suppliers = Supplier::orderBy('supplier_id', 'desc')->get();
      $products = Product::orderBy('product_id', 'desc')->get();
      return view('purchase.product_purchase_new', ['suppliers' => $suppliers, 'products' => $products]);   
   }

   public function addProductPurchase(Request $request){
      $validator = Validator::make($request->all(), [
                                          'supplier_id'   => 'required|integer',
                                          'purchase_date' => 'required',
                                          'item_id'       => 'required'
                                       ], 
                                       [
                                          'item_id.required' => 'Please Add At Leat One Product!'
                                       ]
                  );

      if($validator->fails()) {
         return response()->json(['errors' => $validator->errors()]);
      }

      DB::beginTransaction();

      try{
         $purchase = new ProductPurchase();
         $purchase->supplier_id = $request->supplier_id;
         $purchase->purchase_date = $request->purchase_date;
         $purchase->created_by = auth()->id();
         $purchase->save();

         $details = array_map(function ($product_id, $item_qty, $item_price, $total_price) use ($purchase) {
            return [
               'purchase_id' => $purchase->purchase_id,
               'product_id'  => $product_id,
               'item_qty'    => $item_qty,
               'item_price'  => $item_price,
               'total_price' => $total_price
            ];
         }, $request->item_id, $request->item_qty, $request->item_price, $request->total_price);

         $purchase->details()->createMany($details);

         DB::commit();
         return response()->json(['success' => 'Save Successful !']);
      }
      catch (QueryException $e) {
         DB::rollBack();
         return response()->json(['error' => 'Save Failed !']);
      }
      catch (Throwable $e) {
         DB::rollBack();
         return response()->json(['error' => 'Save Failed !']);
      }
   }

   public function productPurchaseEdit($purchase_id){
      $suppliers = Supplier::orderBy('supplier_id', 'desc')->get();
      $products = Product::orderBy('product_id', 'desc')->get();
      $single = ProductPurchase::with('details.product')->find($purchase_id);
      return view('purchase.product_purchase_edit', ['suppliers' => $suppliers, 'products' => $products, 'single' => $single]);
   }

   public function updateProductPurchase(Request $request, $purchase_id){
      $validator = Validator::make($request->all(), [
                                          'supplier_id'   => 'required|integer',
                                          'purchase_date' => 'required',
                                          'item_id'       => 'required'
                                       ], 
                                       [
                                          'item_id.required' => 'Please Add At Leat One Product!'
                                       ]
                  );

      if($validator->fails()) {
         return response()->json(['errors' => $validator->errors()]);
      }

      DB::beginTransaction();

      try{
         $purchase = ProductPurchase::find($purchase_id);
         $purchase->supplier_id = $request->supplier_id;
         $purchase->purchase_date = $request->purchase_date;
         $purchase->updated_by = auth()->id();
         $purchase->save();

         ProductPurchaseDetail::where('purchase_id', $purchase_id)->delete();

         $details = array_map(function ($product_id, $item_qty, $item_price, $total_price) use ($purchase) {
            return [
               'purchase_id' => $purchase->purchase_id,
               'product_id'  => $product_id,
               'item_qty'    => $item_qty,
               'item_price'  => $item_price,
               'total_price' => $total_price
            ];
         }, $request->item_id, $request->item_qty, $request->item_price, $request->total_price);

         $purchase->details()->createMany($details);

         DB::commit();
         return response()->json(['success' => 'Save Successful !']);
      }
      catch (QueryException $e) {
         DB::rollBack();
         return response()->json(['error' => 'Save Failed !']);
      }
      catch (Throwable $e) {
         DB::rollBack();
         return response()->json(['error' => 'Save Failed !']);
      }
   }

   public function deleteProductPurchase($purchase_id){
      DB::beginTransaction();

      try{
         ProductPurchaseDetail::where('purchase_id', $purchase_id)->delete();

         $purchase = ProductPurchase::find($purchase_id);
         $purchase->delete();

         DB::commit();
         return response()->json(['success' => 'Delete Successful !']);
      } 
      catch (Exception $e){
         DB::rollBack();
         return response()->json(['error' => 'Delete Faild !']);
      }
   }
}
