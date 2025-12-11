<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(
        private UserService $service
    ) {}

    public function index()
    {
        return response()->json($this->service->getAll());
    }

    public function show($id)
    {
        $user = $this->service->findById($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json($user);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            "name" => "required",
            "email" => "required|email|unique:users",
            "password" => "required|min:6",
        ]);

        return response()->json(
            $this->service->create($validated),
            201
        );
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            "name" => "sometimes",
            "email" => "sometimes|email|unique:users",
            "password" => "sometimes|min:6",
        ]);

        return response()->json(
            $this->service->update($id, $validated),
            200
        );
    }

    public function destroy($id)
    {
        $deleted = $this->service->delete($id);

        if ($deleted) {
            return response()->json(null, 204);
        }

        return response()->json(['message' => 'User not found'], 404);
    }
}
