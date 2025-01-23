<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller{
    
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $users = User::orderBy('id', 'desc')->get();
        return view('users.user_info', ['users' => $users]);
    }

    public function userList(Request $request){
        $data = User::select(['user_name', 'email', 'status']); 
        return datatables()->of($data)->make(true);
    }

    public function userNew(){
        return view('users.user_new');   
    }

    public function addUser(Request $request){
        $request->validate([
            'user_name' => 'required|string|max:150',
            'email'     => 'required|string|email|max:150|unique:users',
            'password'  => 'required|string|min:8|confirmed'
        ]);

        $user = new User();
        $user->user_name  = $request->user_name;
        $user->email      = $request->email;
        $user->password   = Hash::make($request->password);
        $user->save();
        return redirect('user-info')->with('success', 'Save successful !');
    }

    public function userEdit($id){
        $user = User::find($id);
        return view('users.user_edit', ['user' => $user]);   
    }

    public function updateUser(Request $request){
        $request->validate([
            'user_name' => 'required|string|max:150',
            'email'     => 'required|string|email|max:150',
            'password'  => 'required|string|min:8|confirmed'
        ]);

        $user = User::find($request->id);

        $user->user_name  = $request->user_name;
        $user->email      = $request->email;
        $user->password   = Hash::make($request->password);
        $user->save();
        return redirect('user-info')->with('success', 'Update successful !');
    }

    public function userDelete($id){
        $user = User::find($id);
        $user->delete();
        return redirect('user-info')->with('success', 'Delete successful !');
    }
}
