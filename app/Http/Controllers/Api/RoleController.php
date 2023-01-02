<?php

namespace App\Http\Controllers\Api;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Services\RoleService;
use Illuminate\Http\Response;
use App\Http\Requests\RoleRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\RoleResource;

class RoleController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Role::class, 'role');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::paginate(10);
        return RoleResource::collection($roles)->additional([
            'can' => [ // Is this the best way to do this?
                'create_role' => request()->user()->can('create', Role::class)
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\RoleRequest  $request
     * @param  \App\Http\Services\RoleService  $service
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request, RoleService $service)
    {
        $role = $service->store($request->validated());
        return $this->apiResponse(
            __("Role created successfully"),
            [
                'role' => new RoleResource($role->load('permissions'))
            ],
            Response::HTTP_CREATED
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        return new RoleResource($role->load('permissions'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\RoleRequest  $request
     * @param  \App\Models\Role  $role
     * @param  \App\Http\Services\RoleService  $service
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequest $request, Role $role, RoleService $service)
    {
        $service->update($request->validated(), $role);
        return $this->apiResponse(
            __("Role updated successfully"),
            [
                'role' => new RoleResource($role->load('permissions'))
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return $this->apiResponse(__('Role deleted successfully'));
    }
}
