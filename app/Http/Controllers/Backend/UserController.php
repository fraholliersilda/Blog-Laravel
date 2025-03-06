<?php

namespace App\Http\Controllers\backend;
use App\DataTables\UsersDataTable;
use App\Exports\UsersExport;
use App\Http\Requests\ImportUsersRequest;
use App\Http\Requests\NewUserRequest;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use App\Imports\UsersImport;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{

    public $userService;

    public function __construct(UserService $userService)
    {
        $this->middleware('auth');
        $this->userService = $userService;
    }

    public function index()
    {
        return view('backend.user.new-all-users');
    }

    public function getUsers()
    {
        try {
            $users = $this->userService->getAllUsersExceptAdminAndCurrent();

            return datatables($users)
                ->addColumn('action', function ($user) {
                    return view('backend.user.action', ['user' => $user]);
                })
                ->make(true);
        } catch (\Throwable $th) {
            Log::error('Error fetching users: ' . $th->getMessage());
            return response()->json(['error' => 'Failed to retrieve users.'], 500);
        }
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

    public function insertUser(NewUserRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $inserted = $this->userService->createUser($validatedData);
            Log::info('Request data:', $request->all());
            if ($inserted) {
                toastr()->success('New user added successfully.');
                return redirect()->route('alluser');
            } else {
                toastr()->error('User creation failed');
                throw new \Exception('User creation failed');
            }
        } catch (\Throwable $th) {
            Log::error('User insertion error: ' . $th->getMessage());
            return redirect()->back();
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
                toastr()->success('User has been updated successfully!');
                return redirect()->route('alluser');
            } else {
                toastr()->error('User update failed');
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
            toastr()->success('User deleted successfully');
            $this->userService->deleteUser($id);
            return redirect()->route('alluser');
        } catch (\Throwable $th) {
            Log::error('User deletion error: ' . $th->getMessage());
            return redirect()->route('alluser')->with('error', 'Failed to delete user.');
        }
    }


    public function importUsers(ImportUsersRequest $request)
    {
        try {
            $success = $this->userService->importUsers($request->file('excel_file'));

            if ($success) {
                toastr()->success('Users imported successfully!');
                return redirect()->back();
            }
            toastr()->error('Failed to import users.');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with($e->getMessage());
        }
    }

    public function export(UserService $userService)
    {
        try {
            return $userService->exportUsers();
        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong during the export process. Please try again later.'], 500);
        }
    }



}
