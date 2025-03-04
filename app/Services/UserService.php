<?php

namespace App\Services;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserService
{

    public function update(array $data)
    {
        $user = Auth::user();
        $user->update($data);
        return $user;
    }


    public function updatePassword(array $data)
    {
        $user = Auth::user();
        $user->update([
            'password' => Hash::make($data['password']),
        ]);
    }

    public function deleteAccount()
    {
        $user = Auth::user();
        $userInfo = [
            'name' => $user->name,
            'email' => $user->email,
        ];

        Auth::logout();
        $user->forceDelete();

        return $userInfo;
    }


    public function getAllNonAdminUsers(int $PerPage = 12)
    {
        return User::where('role_id', '!=', 1)->paginate($PerPage);
    }

    public function createUser(array $data)
    {
        $userData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'role_id' => $data['role_id'],
            'password' => Hash::make($data['password']),
            'created_at' => now(),
            'updated_at' => now(),
        ];

        return DB::table('users')->insert($userData);
    }

    public function getUserById(int $id)
    {
        return DB::table('users')->where('id', $id)->first();
    }


    public function updateUser(int $id, array $data)
    {
        $userData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'updated_at' => now(),
        ];

        if (isset($data['role_id'])) {
            $userData['role_id'] = $data['role_id'];
        }

        return DB::table('users')->where('id', $id)->update($userData) ? true : false;
    }

    public function deleteUser(int $id)
    {
        return DB::table('users')->where('id', $id)->delete() ? true : false;
    }
}
