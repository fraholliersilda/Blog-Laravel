<?php

namespace App\Services;
use App\Exports\UsersExport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UsersImport;
use Exception;
use Illuminate\Http\UploadedFile;

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
        $column = request('column', 'created_at');

        $direction = request('direction', 'desc');

        $allowedColumns = ['name', 'email', 'created_at'];

        if (!in_array($column, $allowedColumns)) {
            $column = 'created_at';
        }

        $direction = in_array(strtolower($direction), ['asc', 'desc'])
            ? $direction
            : 'desc';

        return User::where('role_id', '!=', 1)
            ->orderBy($column, $direction)
            ->paginate($PerPage);
    }

    public function getAllUsersExceptAdminAndCurrent()
    {
        return User::query()
            ->where('role_id', '!=', 1)
            ->where('id', '!=', Auth::id())
            ->get();
    }


    public function createUser(array $data)
    {
        $userData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'role_id' => $data['role_id'],
            'password' => Hash::make($data['password']),
            'language' => 'en',
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

        return DB::table('users')->where('id', $id)->update($userData) > 0;
    }

    public function deleteUser(int $id)
    {
        return DB::table('users')->where('id', $id)->delete() ? true : false;
    }

    public function importUsers(UploadedFile $file): bool
    {
        try {
            Excel::import(new UsersImport, $file);
            return true;
        } catch (Exception $e) {
            \Log::error('User import failed: ' . $e->getMessage());
            return false;
        }
    }

    public function exportUsers()
    {
        try {
            return Excel::download(new UsersExport, 'users_downloaded.xlsx');
        } catch (Exception $e) {
            throw new Exception('Something went wrong during the export process.');
        }
    }
}
