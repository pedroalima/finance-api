<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;

class UserService
{
    public function __construct(
        private UserRepositoryInterface $users
    ) {}

    public function getAll()
    {
        return $this->users->getAll();
    }

    public function findById(int $id)
    {
        return $this->users->findById($id);
    }

        public function create(array $data)
    {
        return $this->users->create($data);
    }

    public function update(int $id, array $data)
    {
        return $this->users->update($id, $data);
    }

    public function delete(int $id)
    {
        return $this->users->delete($id);
    }
}
