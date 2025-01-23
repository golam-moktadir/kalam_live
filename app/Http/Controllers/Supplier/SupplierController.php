<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier\Supplier;

class SupplierController extends Controller{

    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $suppliers = Supplier::orderBy('supplier_id', 'desc')->get();
        return view('supplier.supplier_info', ['suppliers' => $suppliers]);
    }

    public function supplierNew(){
        return view('supplier.supplier_new');   
    }

    public function addSupplier(Request $request){
        $request->validate([
            'supplier_name'  => 'required|string|max:150|unique:suppliers',
            'contact_number' => 'required|numeric|unique:suppliers'
        ]);

        $supplier = new Supplier();
        $supplier->supplier_name  = $request->supplier_name;
        $supplier->contact_number = $request->contact_number;
        $supplier->address        = $request->address;
        $supplier->created_by     = 1;
        $supplier->save();
        return redirect('supplier-info')->with('success', 'Save successful !');
    }

    public function supplierEdit($supplier_id){
        $supplier = Supplier::where('supplier_id', $supplier_id)->first();
        return view('supplier.supplier_edit', ['supplier' => $supplier]);   
    }

    public function updateSupplier(Request $request){
        $request->validate([
            'supplier_name'  => 'required|string|max:150',
            'contact_number' => 'required|numeric'
        ]);

        Supplier::where('supplier_id', $request->supplier_id)
                ->update(['supplier_name'  => $request->supplier_name, 
                          'contact_number' => $request->contact_number,
                          'address'        => $request->address,
                          'updated_by'     => 1
                        ]);
        return redirect('supplier-info')->with('success', 'Update successful !');
    }

    public function supplierDelete($supplier_id){
        Supplier::where('supplier_id', $supplier_id)->delete();
        return redirect('supplier-info')->with('success', 'Delete successful !');
    }
}
