<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(){
        $users = User::where('deleted_at', null)
        ->get();
        return view('welcome', compact('users')); 
    }
    public function deleteUser(Request $request){
        $id = $request->input('id');
        User::where('id', $id)
       ->update([
           'deleted_at' => now()
        ]);
        return response()->json(['success' => 'User Recycled Successfully.']);
    }
    public function fetchUsers(){
        $users = User::where('deleted_at', null)
        ->get();
        return response()->json(['users' => $users]);
    }
    public function recycledUsers(){
        $users = User::whereNotNull('deleted_at')
        ->get();
        return view('recycle', compact('users'));
    }
    public function restoreUser(Request $request){
        $id = $request->input('id');
        User::where('id', $id)
       ->update([
           'deleted_at' => null
        ]);
        return response()->json(['success' => 'User Restored Successfully.']);
    }
    public function temDeletedUsers(Request $request){
        $users = User::whereNotNull('deleted_at')
        ->get();
        return response()->json(['users' => $users]);
    }
    public function permanentDeleteUser(Request $request){
        $id = $request->input('id');
        $deleted = DB::table('users')->where('id', $id)->delete();
        if ($deleted) {
            return response()->json(['success' => 'User Permanently Deleted Successfully.']);
        } else {
            return response()->json(['error' => 'Error deleting user.']);
        }
    }
}
