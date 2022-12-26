@extends('layouts.app')

@section('title', "Your submission for assignment {$assignment->title}")

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
                        <p class="mb-0">Your submission for assignment <b>{{ $assignment->title }}</b></p>
                    </div>
                    <p class="mb-0">Assignment deadline:
                        <span class="text-bolder">{{ $assignment->deadline->diffForHumans() }}</span>
                    </p>

                    <hr>

                    <p class="mb-0">Your submission message:
                        <pre class="text-bolder">{{ $submission->message }}</pre>
                    </p>
                    <p class="mb-0">Your submission file:
                        <a href="{{ url("storage/{$submission->file}") }}" target="_blank">Click here</a>
                    </p>

                    <h1 class="mb-0">Your degree is: <b>{{ $submission->degree ?: 'Not degreed yet' }}</b>
                    </h1>
                </div>
            </div>
        </div>
    </div>
@endsection
