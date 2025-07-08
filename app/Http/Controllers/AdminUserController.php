<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use App\Services\AdminUserService;

class AdminUserController extends Controller
{
    protected AdminUserService $service;

    public function __construct(AdminUserService $service)
    {
        $this->middleware(['auth:sanctum', 'role:admin']);
        $this->service = $service;
    }

    /**
     * Get a list of all users.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $users = $this->service->listUsers();

        return $this->successResponse(
            ['users' => $users],
            'User list retrieved successfully'
        );
    }

    /**
     * Create a new user.
     *
     * @param StoreUserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreUserRequest $request)
    {
        $user = $this->service->createUser($request->validated());

        return $this->successResponse(
            ['user' => $user],
            'User created successfully',
            201
        );
    }

    /**
     * Update an existing user.
     *
     * @param UpdateUserRequest $request
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $updatedUser = $this->service->updateUser($user, $request->validated());

        return $this->successResponse(
            ['user' => $updatedUser],
            'User updated successfully'
        );
    }

    /**
     * Delete a user.
     *
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(User $user)
    {
        $this->service->deleteUser($user);

        return $this->successResponse(
            [],
            'User deleted successfully'
        );
    }

    /**
     * Toggle user active/inactive status.
     *
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggleStatus(User $user)
    {
        $updatedUser = $this->service->toggleActivation($user);

        return $this->successResponse(
            ['user' => $updatedUser],
            'User status toggled successfully'
        );
    }
}

