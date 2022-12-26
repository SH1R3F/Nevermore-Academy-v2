@extends('layouts.app')

@section('title', 'Edit assignment')

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
                    <form method="POST" action="{{ route('assignments.update', $assignment->id) }}">
                        @csrf
                        @method('PATCH')
                        <div class="card-header pb-0">
                            <div class="d-flex align-items-center">
                                <p class="mb-0">Edit assignment <b>{{ $assignment->title }}</b></p>
                                <button class="btn btn-primary btn-sm ms-auto">Save</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="text-uppercase text-sm">Assignment Information</p>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="title" class="form-control-label">Title</label>
                                        <input class="form-control" id="title" type="text" name="title"
                                            value="{{ old('title', $assignment->title) }}">
                                        @error('title')
                                            <span class="text-danger text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="requirement" class="form-control-label">Requirement</label>
                                        <textarea class="form-control" id="requirement" type="text" name="requirement">{{ old('requirement', $assignment->requirement) }}</textarea>
                                        @error('requirement')
                                            <span class="text-danger text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="deadline" class="form-control-label">Deadline</label>
                                        <input class="form-control" id="deadline" type="date" name="deadline"
                                            value="{{ old('deadline', $assignment->deadline->format('Y-m-d')) }}">
                                        @error('deadline')
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
