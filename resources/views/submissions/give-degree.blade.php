@extends('layouts.app')

@section('title', 'Show submission')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <form method="POST" action="{{ route('submissions.update', $submission->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="card-header pb-0">
                            <div class="d-flex align-items-center">
                                <p class="mb-0">Give degree for submission</b></p>
                                <button class="btn btn-primary btn-sm ms-auto">Save</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="text-uppercase text-sm">Submission Information</p>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="message" class="text-lg form-control-label">Message</label>
                                        <pre class="text-bolder">
                                            {{ $submission->message }}
                                        </pre>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="file" class="text-lg form-control-label d-block">File</label>
                                        <a href="{{ url("storage/{$submission->file}") }}" class="text-link"
                                            target="_blank">Submission
                                            file</a>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="degree" class="text-lg form-control-label d-block">DEGREE</label>
                                        <input type="number" name="degree" id="degree" class="form-control"
                                            value="{{ old('degree', $submission->degree) }}">
                                        @error('degree')
                                            <span class="text-danger text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
