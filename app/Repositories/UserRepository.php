<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    /**
     * Get user by email.
     *
     * @param string $email
     * @return User|null
     */
    public function getUserByEmail(string $email): ?User
    {
        return User::whereEmail($email)->first();
    }

    /**
     * Create user.
     *
     * @param array $data
     * @return User
     */
    public function createUser(array $data): User
    {
        return User::create($data);
    }
}
