<?php

namespace App\Http\Controllers\Purchase;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Purchase\ProductPurchase;
use App\Models\Supplier\Supplier;

class ProductPurchaseController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $purchases = ProductPurchase::orderBy('purchase_id', 'desc')->get();
        return view('purchase.product_purchase_info', ['purchases' => $purchases]);
    }

    public function productPurchaseNew(){
        $suppliers = Supplier::orderBy('supplier_id', 'desc')->get();
        return view('purchase.product_purchase_new', ['suppliers' => $suppliers]);   
    }

    public function addProductPurchase(Request $request){
        $request->validate([
                    'supplier_id' => 'required',
                    'purchase_date' => 'required'
                ], ['supplier_id' => 'The Supplier field is required.']);

        // $purchase = new ProductPurchase();
        // $purchase->supplier_id   = $request->supplier_id;
        // $purchase->purchase_date = $request->purchase_date;
        // $purchase->save();
        return redirect('product-purchase')->with('success', 'Save successful !');
    }
}
