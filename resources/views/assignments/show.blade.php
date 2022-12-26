@extends('layouts.app')

@section('title', $assignment->title)

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card p-5">
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
                                <div class="d-flex align-items-center">
                                    <p class="mb-0">{{ $submission->student->name }}</b></p>
                                    @can('update', $assignment)
                                        <a href="{{ route('assignments.edit', $assignment->id) }}"
                                            class="btn btn-primary btn-sm ms-auto">Show</a>
                                    @endcan
                                </div>
                            </li>
                        @endforeach
                    </ul>

                </div>
            </div>
        </div>
    </div>
@endsection
