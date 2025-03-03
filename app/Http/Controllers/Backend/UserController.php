<?php

namespace App\Http\Controllers\backend;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\UserService;


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
        $all = $this->userService->getAllNonAdminUsers();
        return view('backend.user.all-user', compact('all'));
    }


    public function addUserIndex()
    {
        return view('backend.user.add_user');
    }

    public function insertUser(UserRequest $request)
    {
        $validatedData = $request->validated();
        $inserted = $this->userService->createUser($validatedData);
        if ($inserted) {
            return redirect()->route('allUser')->with('success', 'User added successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to add user.');
        }
    }

    public function editUser($id)
    {
        $edit = $this->userService->getUserById($id);
        return view('backend.user.edit_user', compact('edit'));
    }

    public function updateUser(UserRequest $request, $id)
    {
        $validatedData = $request->validated();
        $this->userService->updateUser($id, $validatedData);

        return redirect()->route('allUser')->with('success', 'User updated successfully.');
    }

    public function deleteUser($id)
    {
        $this->userService->deleteUser($id);
        return redirect()->route('allUser')->with('success', 'User deleted successfully.');

    }
}
