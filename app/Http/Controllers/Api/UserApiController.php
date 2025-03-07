<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserCollection;
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

    /**
     * Get all users (except admin users)
     *
     * @return \Illuminate\Http\JsonResponse|\App\Http\Resources\UserCollection
     */
    public function index()
    {
        try {
            $users = $this->userService->getAllUsersExceptAdminAndCurrent();
            return new UserCollection($users->get());
        } catch (\Throwable $th) {
            Log::error('API - Error fetching users: ' . $th->getMessage());
            return response()->json([
                'message' => 'Failed to retrieve users',
                'error' => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Get user by ID
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|\App\Http\Resources\UserResource
     */
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
