@extends('layouts.app')

@section('title', 'List roles')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="card-header pb-0">
                            <h6>Roles of the site</h6>
                        </div>
                        @can('create', 'App\Models\Role')
                            <div class="px-4 pt-3">
                                <a href="{{ route('roles.create') }}" class="btn btn-primary">Create new role</a>
                            </div>
                        @endcan
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            @if (Session::has('status'))
                                <div class="alert alert-success" role="alert">
                                    <strong>Success!</strong> {{ session('status') }}
                                </div>
                            @endif
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Role
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Description
                                        </th>
                                        <th class="text-secondary opacity-7"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($roles as $role)
                                        <tr>
                                            <td>
                                                <h6 class="mb-0 text-sm">{{ $role->name }}</h6>
                                            </td>
                                            <td>
                                                {{ $role->description }}
                                            </td>
                                            <td class="align-middle">
                                                @can('update', $role)
                                                    <a href="{{ route('roles.edit', $role->id) }}"
                                                        class="btn btn-secondary font-weight-bold text-xs mx-1"
                                                        data-toggle="tooltip" data-original-title="Edit role">
                                                        Edit
                                                    </a>
                                                @endcan
                                                @can('delete', $role)
                                                    <form action="{{ route('roles.destroy', $role->id) }}" method="POST"
                                                        class="d-inline">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button type="submit"
                                                            class="btn btn-danger font-weight-bold text-xs mx-1"
                                                            data-toggle="tooltip" data-original-title="Delete role">
                                                            Delete
                                                        </button>
                                                    </form>
                                                @endcan
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center">No roles found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="pagination mt-3">
                                {{ $roles->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
