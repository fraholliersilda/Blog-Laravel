<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\UserService;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class UserApiController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        try {
            $email = request()->query('email');

            if ($email) {
                $users = $this->userService->getUserByEmail($email);

                if (!$users) {
                    return response()->json([
                        'message' => 'User not found',
                    ], Response::HTTP_NOT_FOUND);
                }

                return new UserResource($users);
            }

            $users = $this->userService->getAllUsersExceptAdminAndCurrent();
            return UserResource::collection($users->paginate(10));

        } catch (\Throwable $th) {
            Log::error('API - Error fetching users: ' . $th->getMessage());
            return response()->json([
                'message' => 'Failed to retrieve users',
                'error' => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show($id)
    {
        try {
            $user = $this->userService->getUserById($id);
            return new UserResource($user);
        } catch (\Throwable $th) {
            Log::error('API - Error fetching user: ' . $th->getMessage());
            return response()->json([
                'message' => 'User not found',
                'error' => $th->getMessage()
            ], Response::HTTP_NOT_FOUND);
        }
    }
}
