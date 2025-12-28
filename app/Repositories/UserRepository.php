<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function findByEmail($email)
    {
        return User::where('email', $email)->first();
    }

    public function findById($id)
    {
        return User::find($id);
    }

    public function create(array $data)
    {
        return User::create($data);
    }

    public function update(User $user, array $data)
    {
        $user->update($data);
        return $user;
    }
}
