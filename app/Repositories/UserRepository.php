<?php

namespace App\Repositories;

use App\DTOs\User\UserDTO;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class UserRepository implements UserRepositoryInterface
{
    public function findByEmail(string $email): ?User
    {
        return User::where("email", $email)->first();
    }
    public function getAll(): Collection
    {
        return User::orderBy('name')->get();
    }

    public function findById(int $id): ?User
    {
        return User::find($id);
    }

    public function create(UserDTO $data): User
    {
        $password = bcrypt($data->password);
        return User::create([
            'name' => $data->name,
            'email' => $data->email,
            'password' => $password,
        ]);
    }

    public function update(int $id, UserDTO $data): ?User
    {
        $user = User::find($id);

        if (!$user) return null;

        if (isset($data->password)) {
            $data->password = bcrypt($data->password);
        }

        $user->update($data->toArray());

        return $user;
    }

    public function delete(int $id): bool
    {
        $user = User::find($id);
        return $user ? $user->delete() : false;
    }
}
