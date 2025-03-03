<?php

namespace App\Services;

use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterService
{
    public function getDefaultUserRole()
    {
        return Role::where("name", "user")->first();
    }

    public function createUser(array $data)
    {
        $role = $this->getDefaultUserRole();

        $user = User::create([
            "name" => $data["name"],
            "email" => $data["email"],
            "password" => Hash::make($data["password"]),
            "role_id" => $role->id,
        ]);

        Auth::login($user);
        return $user;
    }

    public function hasDefaultUserRole()
    {
        return $this->getDefaultUserRole() !== null;
    }
}
