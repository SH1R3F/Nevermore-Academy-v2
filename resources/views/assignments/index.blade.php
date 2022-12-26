@extends('layouts.app')

@section('title', 'List assignments')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="card-header pb-0">
                            <h6>Assignments</h6>
                        </div>
                        @can('create', 'App\Models\Assignment')
                            <div class="px-4 pt-3">
                                <a href="{{ route('assignments.create') }}" class="btn btn-primary">Create new assignment</a>
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
                                            Assignment title
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Requirements
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Teacher
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Deadline
                                        </th>
                                        <th class="text-secondary opacity-7"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($assignments as $assignment)
                                        <tr>
                                            <td style="white-space: normal;">
                                                <h6 class="mb-0 text-sm">{{ $assignment->title }}</h6>
                                            </td>
                                            <td style="white-space: normal;">
                                                {{ $assignment->requirement }}
                                            </td>
                                            <td>
                                                {{ $assignment->teacher->name }}
                                            </td>
                                            <td>
                                                {{ $assignment->deadline->diffForHumans() }}
                                            </td>
                                            <td class="align-middle">
                                                @can('view', $assignment)
                                                    <a href="{{ route('assignments.show', $assignment->id) }}"
                                                        class="btn btn-primary font-weight-bold text-xs mx-1"
                                                        data-toggle="tooltip" data-original-title="Show assignment">
                                                        Show
                                                    </a>
                                                @endcan
                                                @can('update', $assignment)
                                                    <a href="{{ route('assignments.edit', $assignment->id) }}"
                                                        class="btn btn-secondary font-weight-bold text-xs mx-1"
                                                        data-toggle="tooltip" data-original-title="Edit assignment">
                                                        Edit
                                                    </a>
                                                @endcan
                                                @can('delete', $assignment)
                                                    <form action="{{ route('assignments.destroy', $assignment->id) }}"
                                                        method="POST" class="d-inline">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button type="submit"
                                                            class="btn btn-danger font-weight-bold text-xs mx-1"
                                                            data-toggle="tooltip" data-original-title="Delete assignment">
                                                            Delete
                                                        </button>
                                                    </form>
                                                @endcan
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center">No assignments found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="pagination mt-3">
                                {{ $assignments->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
