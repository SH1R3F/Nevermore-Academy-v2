@extends('layouts.app')

@section('title', 'Edit a role')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                @if (Session::has('status'))
                    <div class="alert alert-success" role="alert">
                        <strong>Success!</strong> {{ session('status') }}
                    </div>
                @endif
                <div class="card">
                    <form method="POST" action="{{ route('roles.update', $role->id) }}">
                        @method('PATCH')
                        @csrf
                        <div class="card-header pb-0">
                            <div class="d-flex align-items-center">
                                <p class="mb-0">Edit role <b>{{ $role->name }}</b></p>
                                <button class="btn btn-primary btn-sm ms-auto">Save</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="text-uppercase text-sm">Role Information</p>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="name" class="form-control-label">Name</label>
                                        <input class="form-control" id="name" type="text" name="name"
                                            value="{{ old('name', $role->name) }}">
                                        @error('name')
                                            <span class="text-danger text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="description" class="form-control-label">Description</label>
                                        <input class="form-control" id="description" type="text" name="description"
                                            value="{{ old('description', $role->description) }}">
                                        @error('description')
                                            <span class="text-danger text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                            </div>

                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            permission
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Description
                                        </th>
                                        <th class="text-secondary opacity-7"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($permissions as $permission)
                                        <tr>
                                            <td>
                                                <h6 class="mb-0 text-sm">
                                                    <label for="{{ $permission->slug }}">
                                                        <input type="checkbox" name="permissions[{{ $permission->slug }}]"
                                                            id="{{ $permission->slug }}"
                                                            {{ $role->hasPermission($permission->slug) ? 'checked' : '' }}>
                                                        {{ $permission->slug }}
                                                    </label>
                                                </h6>
                                            </td>
                                            <td>
                                                {{ $permission->description }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
