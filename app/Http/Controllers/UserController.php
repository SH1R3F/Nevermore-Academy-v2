<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Policies\UserPolicy;
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
        $users = User::with('role')
            ->orderBy('id')
            ->paginate(10);

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::orderBy('id')->get(['id', 'name']);
        return view('users.create', compact('roles'));
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
        $roles = Role::orderBy('id')->get(['id', 'name']);
        return view('users.edit', compact('user', 'roles'));
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
