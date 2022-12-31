<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Services\UserService;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{

    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $auth = request()->user();

        $users = User::with('role')
            ->orderBy('id')
            ->paginate(10, ['id', 'name', 'email', 'role_id']);


        return inertia('Users/Index', [
            'users' => $users->through(function ($user) use ($auth) {
                $user->avatar = $user->getFirstMediaUrl('images');
                $user->editable = $auth->can('update', $user);
                $user->deleteable = $auth->can('delete', $user);
                return $user;
            }),
            'can' => [
                'create_user' => $auth->can('create', User::class)
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
        $roles = Role::orderBy('id')->get(['id', 'name']);
        return inertia('Users/Create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @param  \App\Services\UserService  $service
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request, UserService $service)
    {
        $service->store($request->validated());
        return redirect()->route('users.index')->with('status', 'User created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $user->avatar = $user->getFirstMediaUrl('images');
        $roles = Role::orderBy('id')->get(['id', 'name']);
        return inertia('Users/Edit', [
            'user' => $user->load('role'),
            'roles' => $roles
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @param  \App\Models\User  $user
     * @param  \App\Services\UserService  $service
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user, UserService $service)
    {
        $service->update($request->validated(), $user);

        return redirect()->back()->with('status', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        // Delete his media!
        $user->clearMediaCollection();
        $user->delete();
        return redirect()->back()->with('status', 'User deleted successfully');
    }
}
