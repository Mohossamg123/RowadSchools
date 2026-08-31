<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Permission\StorePermissionRequest;
use App\Http\Requests\Permission\UpdatePermissionRequest;
use App\Http\Resources\PermissionResource;
use App\Models\Permission;
use Illuminate\Http\JsonResponse;

class PermissionController extends Controller
{
    public function index(): JsonResponse
    {
        $permissions = Permission::query()
            ->orderBy('name')
            ->get();

        return response()->json([
            'success' => true,
            'data' => PermissionResource::collection($permissions),
        ]);
    }

    public function store(
        StorePermissionRequest $request
    ): JsonResponse {
        $permission = Permission::create(
            $request->validated()
        );

        return response()->json([
            'success' => true,
            'message' => 'Permission created successfully.',
            'data' => new PermissionResource($permission),
        ], 201);
    }

    public function show(Permission $permission): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => new PermissionResource($permission),
        ]);
    }

    public function update(
        UpdatePermissionRequest $request,
        Permission $permission
    ): JsonResponse {
        $permission->update(
            $request->validated()
        );

        return response()->json([
            'success' => true,
            'message' => 'Permission updated successfully.',
            'data' => new PermissionResource($permission),
        ]);
    }

    public function destroy(Permission $permission): JsonResponse
    {
        $permission->delete();

        return response()->json([
            'success' => true,
            'message' => 'Permission deleted successfully.',
        ]);
    }
}
