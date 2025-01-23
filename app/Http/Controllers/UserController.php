<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class UserController extends Controller{
    
   public function __construct(){
      $this->middleware('auth');
   }

   public function index(){
      return view('users.user_info');
   }

   public function userList(Request $request){
      $data = User::select(['id', 'user_name', 'email', 'status']); 
      return datatables()->of($data)->make(true);
   }

   public function addUser(Request $request){
      $validator = Validator::make($request->all(), [
         'user_name' => 'required|string|max:150',
         'email'     => 'required|string|email|max:150|unique:users',
         'password'  => 'required|string|min:8|confirmed'
      ]);

      if($validator->fails()) {
         return response()->json(['errors' => $validator->errors()]);
      }

      DB::beginTransaction();

      try{
         $user = new User();
         $user->user_name  = $request->user_name;
         $user->email      = $request->email;
         $user->password   = Hash::make($request->password);
         $user->save();

         DB::commit();
         return response()->json(['success' => 'Save Successful !']);
      } 
      catch (Exception $e){
         DB::rollBack();
         return response()->json(['error' => 'Save Faild !']);
         //$e->getMessage()
      }
   }

   public function updateUser(Request $request, $id){
      $validator = Validator::make($request->all(), [
         'user_name' => 'required|string|max:150',
         'email'     => 'required|string|email|max:150',
         'password'  => 'required|string|min:8|confirmed'
      ]);

      if($validator->fails()) {
         return response()->json(['errors' => $validator->errors()]);
      }

      DB::beginTransaction();

      try{
         $user = User::find($id);
         $user->user_name  = $request->user_name;
         $user->email      = $request->email;
         $user->password   = Hash::make($request->password);
         $user->save();

         DB::commit();
         return response()->json(['success' => 'Update Successful !']);
      } 
      catch (Exception $e){
         DB::rollBack();
         return response()->json(['error' => 'Update Faild !']);
      }
   }

   public function userDelete($id){

      DB::beginTransaction();

      try{
         $user = User::find($id);
         $user->delete();

         DB::commit();
         return response()->json(['success' => 'Delete Successful !']);
      } 
      catch (Exception $e){
         DB::rollBack();
         return response()->json(['error' => 'Delete Faild !']);
      }
   }
}
