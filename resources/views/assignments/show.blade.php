@extends('layouts.app')

@section('title', $assignment->title)

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card p-5">
                    @if (Session::has('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="d-flex align-items-center">
                        <p class="mb-0">Assignment <b>{{ $assignment->title }}</b></p>
                        @can('update', $assignment)
                            <a href="{{ route('assignments.edit', $assignment->id) }}"
                                class="btn btn-primary btn-sm ms-auto">Edit</a>
                        @endcan
                    </div>
                    <p class="mb-0">Assignment requirement:
                        <pre class="text-bolder">{{ $assignment->requirement }}</pre>
                    </p>
                    <p class="mb-0">Assignment deadline:
                        <span class="text-bolder">{{ $assignment->deadline->diffForHumans() }}</span>
                    </p>

                    <hr>

                    <p class="mb-0">Total submissions:
                        <span class="text-bolder">
                            {{ $assignment->submissions_count ?: 'No submissions yet' }}
                        </span>
                    </p>

                    <ul>
                        @foreach ($assignment->submissions as $submission)
                            <li class="w-50">
                                <div class="d-flex align-items-center justify-content-between">
                                    <p class="mb-0">{{ $submission->student->name }}</b></p>
                                    @if ($submission->degree)
                                        <div>
                                            <span class="text-bolder">Degree: {{ $submission->degree }}</span>
                                            <a href="{{ route('submissions.edit', $submission->id) }}"
                                                class="btn btn-default btn-sm">Show submission</a>
                                        </div>
                                    @else
                                        @can('update', $submission)
                                            <a href="{{ route('submissions.edit', $submission->id) }}"
                                                class="btn btn-primary btn-sm ms-auto">Give degree</a>
                                        @endcan
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ul>

                </div>
            </div>
        </div>
    </div>
@endsection
