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
            ->where('id', '!=', Auth::id());
    }

    public function createUser(array $data)
    {
        $trashedUser = User::onlyTrashed()->where('email', $data['email'])->first();

        if ($trashedUser) {
            $trashedUser->forceDelete();
        }

        $userData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'role_id' => $data['role_id'],
            'password' => Hash::make($data['password']),
            'language' => $data['language'] ?? 'en',
            'created_at' => now(),
            'updated_at' => now(),
        ];

        return User::create($userData) ? true : false;
    }

    public function getUserById(int $id)
    {
        return User::findOrFail($id);
    }

    public function getUserByEmail($email)
    {       return User::where('email', $email)->first();
    }

    public function updateUser(int $id, array $data)
    {
        $user = User::findOrFail($id);
        return $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'updated_at' => now(),
        ]);
    }


    public function deleteUser(int $id)
    {
        $user = User::findOrFail($id);
        return $user->delete();
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
