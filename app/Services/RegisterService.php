<?php

namespace App\Services;

use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RegisterService
{
    public function getDefaultUserRole()
    {
        return Role::where("name", "user")->first();
    }

    public function hasDefaultUserRole()
    {
        return $this->getDefaultUserRole() !== null;
    }

    public function createUser(array $data)
    {
        if (!$this->hasDefaultUserRole()) {
            return back()->withErrors(['role' => 'The default User role is missing. Contact the admin.']);
        }

        $role = $this->getDefaultUserRole();
        if (!$role) {
            return back()->withErrors(['role' => 'Could not retrieve the default user role.']);
        }

        $existingUser = User::withTrashed()->where('email', $data['email'])->first();

        if ($existingUser) {
            if ($existingUser->trashed()) {
                $existingUser ->forceDelete();
        }else{
            return back()->withErrors(['email'=>'This email is already in use']);
        }
    }

        return DB::transaction(function () use ($data, $role) {
            $user = User::create([
                "name" => $data["name"],
                "email" => $data["email"],
                "password" => Hash::make($data["password"]),
                "role_id" => $role->id,
            ]);

            Auth::login($user);
            return $user;
        });
    }
}
