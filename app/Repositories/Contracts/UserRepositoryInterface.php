<?php

namespace App\Repositories\Contracts;

use App\DTOs\User\UserDTO;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
    public function findByEmail(string $email): ?User;
    public function getAll(): Collection;
    public function findById(int $id): ?User;
    public function create(UserDTO $data): User;
    public function update(int $id, UserDTO $data): ?User;
    public function delete(int $id): bool;
}
