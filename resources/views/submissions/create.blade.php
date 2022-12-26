@extends('layouts.app')

@section('title', 'Submit to an assignment')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <form method="POST" action="{{ route('submissions.store', $assignment->id) }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="card-header pb-0">
                            <div class="d-flex align-items-center">
                                <p class="mb-0">Submit to assignment: <b>{{ $assignment->title }}</b></p>
                                <button class="btn btn-primary btn-sm ms-auto">Save</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="text-uppercase text-sm">Submission</p>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="message" class="form-control-label">Message</label>
                                        <textarea class="form-control" id="message" type="text" name="message">{{ old('message') }}</textarea>
                                        @error('message')
                                            <span class="text-danger text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="file" class="form-control-label">File</label>
                                        <input type="file" class="form-control" id="file" name="file">
                                        @error('file')
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
