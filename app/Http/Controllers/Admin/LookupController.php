<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Lookup;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class LookupController extends Controller{

    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        return view('admin.lookup.lookup_info');
    }

    public function lookupList(Request $request){
      $data = Lookup::select(['lookup_id', 'lookup_group', 'lookup_label', 'lookup_value', 'lookup_order']); 
      return datatables()->of($data)->make(true);
    }

    public function addLookup(Request $request){
        $validator = Validator::make($request->all(), [
            'lookup_group'  => 'required|string|max:150',
            'lookup_label'  => 'required|string|max:150',
            'lookup_value'  => 'required|numeric|max:99',
            'lookup_order'  => 'required|numeric|max:99'
        ]);

        if($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        DB::beginTransaction();

        try{
            $lookup = new Lookup();
            $lookup->lookup_group  = strtoupper($request->lookup_group);
            $lookup->lookup_label  = $request->lookup_label;
            $lookup->lookup_value  = $request->lookup_value;
            $lookup->lookup_order  = $request->lookup_order;
            $lookup->save();

            DB::commit();
            return response()->json(['success' => 'Save Successful !']);
        } 
        catch (Exception $e){
            DB::rollBack();
            return response()->json(['error' => 'Save Faild !']);
        }
    }

    public function updateLookup(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'lookup_group'  => 'required|string|max:150',
            'lookup_label'  => 'required|string|max:150',
            'lookup_value'  => 'required|numeric|max:99',
            'lookup_order'  => 'required|numeric|max:99'
        ]);

        if($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        DB::beginTransaction();

        try{
            $lookup = Lookup::find($id);
            $lookup->lookup_group  = strtoupper($request->lookup_group);
            $lookup->lookup_label  = $request->lookup_label;
            $lookup->lookup_value  = $request->lookup_value;
            $lookup->lookup_order  = $request->lookup_order;
            $lookup->save();

            DB::commit();
            return response()->json(['success' => 'Save Successful !']);
        } 
        catch (Exception $e){
            DB::rollBack();
            return response()->json(['error' => 'Save Faild !']);
        }
    }

    public function deleteLookup($id){
        DB::beginTransaction();

        try{
            $lookup = Lookup::find($id);
            $lookup->delete();

            DB::commit();
            return response()->json(['success' => 'Delete Successful !']);
        } 
        catch (Exception $e){
            DB::rollBack();
            return response()->json(['error' => 'Delete Faild !']);
        }
    }
}
