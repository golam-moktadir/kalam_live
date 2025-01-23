<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller{
    
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $users = User::orderBy('id', 'desc')->get();
        return view('admin.users.user_info', ['users' => $users]);
    }

   public function addUser(Request $request){

      $validator = Validator::make($request->all(), [
         'user_name' => 'required|string|max:150',
         'email'     => 'required|string|email|max:150|unique:users',
         'password'  => 'required|string|min:8|confirmed'
      ]);

      if($validator->fails()){
         return response()->json(['errors' => $validator->errors()]);
      }
    
      // $user = new User();
      // $user->user_name  = $request->user_name;
      // $user->email      = $request->email;
      // $user->password   = $request->password;
      // $user->save();
      // return response()->json(['message' => 'Save successful!']);
   }
}
