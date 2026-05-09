<?php

namespace App\Services;

use App\DTOs\User\LoginDTO;
use App\DTOs\User\UserDTO;
use App\Mail\ResetPasswordMail;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
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
            $token = Str::random(60);

            $link = route('password.reset', ['token' => $token, 'email' => $user->email]);

            // Envia o e-mail
            Mail::to($user->email)->send(new ResetPasswordMail($user->name, $link));

        }

        return ['message' => 'Se o e-mail existir, as instruções foram enviadas.'];
    }

    public function updatePassword(UserDTO $data)
    {
        $user = User::where('email', $data->email)->first();

        if (!$user) {
            throw new \Exception("Usuário não encontrado.");
        }

        $updateDTO = new UserDTO(
            name: $user->name,
            email: $user->email,
            password: $data->password
        );

        return $this->update($user->id, $updateDTO);
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
