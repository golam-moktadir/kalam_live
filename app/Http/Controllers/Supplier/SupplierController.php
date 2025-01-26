<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier\Supplier;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller{

    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        return view('supplier.supplier_info');
    }

    public function supplierList(Request $request){
        $data = Supplier::select(['supplier_id', 'supplier_name', 'contact_number', 'address']); 
        return datatables()->of($data)->make(true);
    }

    public function addSupplier(Request $request){
        $validator = Validator::make($request->all(), [
            'supplier_name'  => 'required|string|max:150|unique:suppliers',
            'contact_number' => 'required|numeric|unique:suppliers'
        ]);

        if($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        DB::beginTransaction();

        try{
            $supplier = new Supplier();
            $supplier->supplier_name  = $request->supplier_name;
            $supplier->contact_number = $request->contact_number;
            $supplier->address        = $request->address;
            $supplier->created_by     = 1;
            $supplier->save();

            DB::commit();
            return response()->json(['success' => 'Save Successful !']);
        } 
        catch (Exception $e){
            DB::rollBack();
            return response()->json(['error' => 'Save Faild !']);
        }
    }

    public function updateSupplier(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'supplier_name'  => 'required|string|max:150',
            'contact_number' => 'required|numeric'
        ]);

        if($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        DB::beginTransaction();

        try{
            $supplier = Supplier::find($id);
            $supplier->supplier_name  = $request->supplier_name;
            $supplier->contact_number = $request->contact_number;
            $supplier->address        = $request->address;
            $supplier->created_by     = 1;
            $supplier->save();

            DB::commit();
            return response()->json(['success' => 'Save Successful !']);
        } 
        catch (Exception $e){
            DB::rollBack();
            return response()->json(['error' => 'Save Faild !']);
        }
    }

    public function supplierDelete($id){
        DB::beginTransaction();

        try{
            $supplier = Supplier::find($id);
            $supplier->delete();

            DB::commit();
            return response()->json(['success' => 'Delete Successful !']);
        } 
        catch (Exception $e){
            DB::rollBack();
            return response()->json(['error' => 'Delete Faild !']);
        }
    }
}
