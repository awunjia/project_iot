<?php

namespace App\Repositories;

use App\Models\User;

class UserRepo
{
    public function createUser(array $data): User
    {
        return User::create($data);
    }

    public function findUserByEmail(string $email): ? User
    {
        return User::where('email', $email)->first();
    }

    public function findUserById(int $id): ? User
    {
        return User::findOrFail($id);
    }

    public function updateUser(int $id, array $data): User
    {
        $user = $this->find($id);
        $user->update($data);
        return $user;
    }

    public function deleteUser(int $id): bool
    {
        $user = $this->find($id);
        return $user ? $user->delete() : false;
    }

    public function getAllUsers(): array
    {
        return User::all()->toArray();
    }
}