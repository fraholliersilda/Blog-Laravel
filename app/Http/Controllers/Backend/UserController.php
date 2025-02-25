<?php

namespace App\Http\Controllers\backend;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function allUser()
    {
        $all = DB::table('users')->where('role_id', '!=', 1)->get();
        return view('backend.user.all-user', compact('all'));
    }


    public function addUserIndex()
    {
        return view('backend.user.add_user');
    }

    public function insertUser(UserRequest $request)
    {
        $request->validated();

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => $request->role_id,
            'password' => Hash::make($request->password),
            'created_at' => now(),
            'updated_at' => now(),
        ];

        $insert = DB::table('users')->insert($data);
        if ($insert) {
            return redirect()->route('allUser')->with('success', 'User added successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to add user.');
        }
    }

    public function editUser($id)
    {
        $edit = DB::table('users')->where('id', $id)->first();
        return view('backend.user.edit_user', compact('edit'));
    }

    public function updateUser(Request $request, $id)
    {
        $request->validated();

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => $request->role_id,
            'updated_at' => now(),
        ];


        DB::table('users')->where('id', $id)->update($data);

        return redirect()->route('allUser')->with('success', 'User updated successfully.');
    }

    public function deleteUser($id)
    {
        DB::table('users')->where('id', $id)->delete();
        return redirect()->route('allUser')->with('success', 'User deleted successfully.');

    }
}
