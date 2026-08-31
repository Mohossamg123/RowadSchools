<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreAdminRequest;
use App\Http\Resources\UserResource;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\User\UpdateAdminRequest;

class UserController extends Controller
{
    public function index(): JsonResponse
    {
        $users = User::with('roles')
            ->latest()
            ->paginate(20);

        return response()->json([
            'success' => true,
            'data' => UserResource::collection($users),
        ]);
    }

    public function store(StoreAdminRequest $request): JsonResponse
    {
        $role = Role::findOrFail(
            $request->validated('role_id')
        );

        $user = User::create([
            'name' => $request->validated('name'),

            'email' => $request->validated('email'),

            'phone' => $request->validated('phone'),

            'password' => Hash::make(
                $request->validated('password')
            ),

            'language' => $request->validated('language', 'en'),

            'status' => $request->validated(
                'status',
                'active'
            ),
        ]);

        $user->roles()->sync([
            $role->id,
        ]);

        $user->load('roles');

        return response()->json([
            'success' => true,
            'message' => 'Admin account created successfully.',
            'data' => new UserResource($user),
        ], 201);
    }

    public function show(User $user): JsonResponse
    {
        $user->load('roles');

        return response()->json([
            'success' => true,
            'data' => new UserResource($user),
        ]);
    }

    public function update(
        UpdateAdminRequest $request,
        User $user
    ): JsonResponse {
        $data = $request->validated();

        if (!empty($data['password'])) {
            $data['password'] = Hash::make(
                $data['password']
            );
        } else {
            unset($data['password']);
        }

        $roleId = $data['role_id'] ?? null;

        unset($data['role_id']);

        $user->update($data);

        if ($roleId) {
            $user->roles()->sync([
                $roleId,
            ]);
        }

        $user->load('roles');

        return response()->json([
            'success' => true,
            'message' => 'Admin account updated successfully.',
            'data' => new UserResource($user),
        ]);
    }

    public function destroy(User $user): JsonResponse
    {
        if ($user->id === request()->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot delete your own account.',
            ], 422);
        }

        $user->tokens()->delete();

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'Admin account deleted successfully.',
        ]);
    }
}
