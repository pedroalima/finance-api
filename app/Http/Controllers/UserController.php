<?php

namespace App\Http\Controllers;

use App\DTOs\User\LoginDTO;
use App\DTOs\User\UserDTO;
use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Services\UserService;

class UserController extends Controller
{
    public function __construct(
        private UserService $userService
    ) {}

    public function index()
    {
        return response()->json($this->userService->getAll());
    }

    public function show($id)
    {
        $user = $this->userService->findById($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json($user);
    }

    public function login(LoginRequest $request)
    {
        $loginDTO = LoginDTO::fromRequest($request);

        return response()->json(
            $this->userService->login($loginDTO)
        );
    }

    public function store(StoreUserRequest $request)
    {
        $userDTO = UserDTO::fromRequest($request);

        return response()->json(
            $this->userService->create($userDTO),
            201
        );
    }

    public function update(UpdateUserRequest $request, $id)
    {
        $userDTO = UserDTO::fromRequest($request);

        return response()->json(
            $this->userService->update($id, $userDTO),
            200
        );
    }

    public function destroy($id)
    {
        $deleted = $this->userService->delete($id);

        if ($deleted) {
            return response()->json(null, 204);
        }

        return response()->json(['message' => 'User not found'], 404);
    }
}
