<?php

namespace App\Http\Controllers\backend;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{

    public $userService;

    public function __construct(UserService $userService)
    {
        $this->middleware('auth');
        $this->userService = $userService;
    }

    public function allUser()
    {
        try {
            $all = $this->userService->getAllNonAdminUsers();
            return view('backend.user.all-user', compact('all'));
        } catch (\Throwable $th) {
            Log::error('Error fetching users: ' . $th->getMessage());
            return redirect()->back()->with('error', 'Failed to retrieve users.');
        }
    }

    public function addUserIndex()
    {
        return view('backend.user.add_user');
    }

    public function insertUser(UserRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $inserted = $this->userService->createUser($validatedData);

            if ($inserted) {
                return redirect()->route('alluser')->with('success', 'User added successfully.');
            } else {
                throw new \Exception('User creation failed');
            }
        } catch (\Throwable $th) {
            Log::error('User insertion error: ' . $th->getMessage());
            return redirect()->back()->with('error', 'Failed to add user.');
        }
    }

    public function editUser($id)
    {
        try {
            $edit = $this->userService->getUserById($id);
            return view('backend.user.edit_user', compact('edit'));
        } catch (\Throwable $th) {
            Log::error('Error fetching user for edit: ' . $th->getMessage());
            return redirect()->route('alluser')->with('error', 'Failed to retrieve user details.');
        }
    }

    public function updateUser(UserRequest $request, $id)
    {
        try {
            $validatedData = $request->validated();
            $updated = $this->userService->updateUser($id, $validatedData);

            if ($updated) {
                return redirect()->route('alluser')->with('success', 'User updated successfully.');
            } else {
                throw new \Exception('User update failed');
            }
        } catch (\Throwable $th) {
            Log::error('User update error: ' . $th->getMessage());
            return redirect()->back()->with('error', 'Failed to update user.');
        }
    }



    public function deleteUser($id)
    {
        try {
            $this->userService->deleteUser($id);
            return redirect()->route('alluser')->with('success', 'User deleted successfully.');
        } catch (\Throwable $th) {
            Log::error('User deletion error: ' . $th->getMessage());
            return redirect()->route('alluser')->with('error', 'Failed to delete user.');
        }
    }
}
