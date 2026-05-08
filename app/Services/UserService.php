<?php

namespace App\Services;

use App\DTOs\User\LoginDTO;
use App\DTOs\User\UserDTO;
use App\Mail\ResetPasswordMail;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class UserService
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {}

    public function login(LoginDTO $data)
    {
        $user = $this->userRepository->findByEmail($data->email);

        if (!$user || !password_verify($data->password, $user->password)) {
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

    public function create(UserDTO $data)
    {
        return $this->userRepository->create($data);
    }

    public function forgotPassword(UserDTO $data)
    {
        $user = User::where('email', $data->email)->first();

        if ($user) {
            $link = "https://meuapp.com/reset-password?token=XYZ123"; // Simulação

            // Envia o e-mail
            Mail::to($user->email)->send(new ResetPasswordMail($user->name, $link));

            return ['message' => 'Se o e-mail existir, as instruções foram enviadas.'];
        } else {

            return ['message' => 'Não foi possível encontrar um usuário com esse e-mail.'];
        }
    }

    public function update(int $id, UserDTO $data)
    {
        return $this->userRepository->update($id, $data);
    }

    public function delete(int $id)
    {
        return $this->userRepository->delete($id);
    }
}
