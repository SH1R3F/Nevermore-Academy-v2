@extends('layouts.app')

@section('title', 'List my submissions')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="card-header pb-0">
                            <h6>My submission</h6>
                        </div>
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
                                            Assignment
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Teacher
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Deadline
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Submission date
                                        </th>
                                        <th class="text-secondary opacity-7"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($submissions as $submission)
                                        <tr>
                                            <td style="white-space: normal;">
                                                <h6 class="mb-0 text-sm">{{ $submission->assignment->title }}</h6>
                                            </td>
                                            <td style="white-space: normal;">
                                                {{ $submission->assignment->teacher->name }}
                                            </td>
                                            <td>
                                                {{ $submission->assignment->deadline->diffForHumans() }}
                                            </td>
                                            <td>
                                                {{ $submission->created_at->diffForHumans() }}
                                            </td>
                                            <td class="align-middle">
                                                @can('view', ['App\Models\Submission', $submission->assignment])
                                                    <a href="{{ route('submissions.show', $submission->assignment->id) }}"
                                                        class="btn btn-primary font-weight-bold text-xs mx-1"
                                                        data-toggle="tooltip" data-original-title="Show assignment">
                                                        Show submission
                                                    </a>
                                                @endcan
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center">No submissions found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="pagination mt-3">
                                {{ $submissions->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
