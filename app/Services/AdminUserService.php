<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminUserService
{
    public function listUsers()
    {
        return User::with('roles', 'permissions')->paginate(20);
    }

    public function createUser(array $data): User
    {
        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        if (isset($data['role'])) {
            $user->assignRole($data['role']);
        }

        return $user;
    }

    public function updateUser(User $user, array $data): User
    {
        $updateFields = [
            'name'  => $data['name'] ?? $user->name,
            'email' => $data['email'] ?? $user->email,
        ];

        if (!empty($data['password'])) {
            $updateFields['password'] = Hash::make($data['password']);
        }

        $user->update($updateFields);

        if (isset($data['role'])) {
            $user->syncRoles([$data['role']]);
        }

        Log::info('Update Data:', $data);

        return $user;



    }

    public function deleteUser(User $user): void
    {
        $user->delete();
    }


    public function toggleActivation(User $user): User
    {
        $user->is_active = !$user->is_active;
        $user->save();

        return $user;
    }
}

