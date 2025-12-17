<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Validation\ValidationException;

class UserService
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {}

    public function login(array $data)
    {
        $user = $this->userRepository->findByEmail($data['email']);

        if (!$user || !password_verify($data['password'], $user->password)) {
            throw ValidationException::withMessages(['email' => 'Email ou senha incorretos']);
        }

        $token = $user->createToken('mobile')->plainTextToken;

        return [
            'token' => $token,
            'user' => $user,
        ];
    }

    public function getAll()
    {
        return $this->userRepository->getAll();
    }

    public function findById(int $id)
    {
        return $this->userRepository->findById($id);
    }

        public function create(array $data)
    {
        return $this->userRepository->create($data);
    }

    public function update(int $id, array $data)
    {
        return $this->userRepository->update($id, $data);
    }

    public function delete(int $id)
    {
        return $this->userRepository->delete($id);
    }
}
