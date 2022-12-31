<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use App\Models\Role;
use App\Models\Permission;
use App\Services\RoleService;
use Illuminate\Http\Request;

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
        $user = request()->user();

        return inertia('Roles/Index', [
            'roles' => $roles->through(function ($role) use ($user) {
                $role->editable = $user->can('update', $role);
                $role->deleteable = $user->can('delete', $role);
                return $role;
            }),
            'can' => [
                'create_role' => $user->can('create', Role::class)
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::orderBy('id')->get(['slug', 'description']);
        return inertia('Roles/Create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\RoleRequest  $request
     * @param  \App\Services\RoleService  $service
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request, RoleService $service)
    {
        $service->store($request->validated());
        return redirect()->route('roles.index')->with('status', 'Role created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $permissions = Permission::orderBy('id')->get(['slug', 'description']);
        return inertia('Roles/Edit', [
            'role' => $role,
            'permissions' => $permissions->map(function ($permission) use ($role) {
                $permission->taken = $role->hasPermission($permission->slug);
                return $permission;
            })
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\RoleRequest  $request
     * @param  \App\Models\Role  $role
     * @param  \App\Services\RoleService  $service
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequest $request, Role $role, RoleService $service)
    {
        $service->update($request->validated(), $role);
        return redirect()->back()->with('status', 'Role updated successfully');
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
        return redirect()->back()->with('status', 'Role deleted successfully');
    }
}
