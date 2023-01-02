<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Http\Response;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;

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

        return UserResource::collection($users)->additional([
            'can' => [ // Is this the best way to do this?
                'create_user' => request()->user()->can('create', User::class)
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request, UserService $service)
    {
        $user = $service->store($request->validated());
        return $this->apiResponse(__('User created successfully'), [
            'user' => new UserResource($user)
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return new UserResource($user);
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

        return $this->apiResponse(__('User updated successfully'), [
            'user' => new UserResource($user)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->clearMediaCollection();
        $user->delete();
        return $this->apiResponse(__('User deleted successfully'));
    }
}
