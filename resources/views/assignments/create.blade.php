@extends('layouts.app')

@section('title', 'Create a new assignment')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <form method="POST" action="{{ route('assignments.store') }}">
                        @csrf
                        <div class="card-header pb-0">
                            <div class="d-flex align-items-center">
                                <p class="mb-0">Create a new assignment</p>
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
                                            value="{{ old('title') }}">
                                        @error('title')
                                            <span class="text-danger text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="requirement" class="form-control-label">Requirement</label>
                                        <textarea class="form-control" id="requirement" type="text" name="requirement">{{ old('requirement') }}</textarea>
                                        @error('requirement')
                                            <span class="text-danger text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="deadline" class="form-control-label">Deadline</label>
                                        <input type="date" class="form-control" id="deadline" name="deadline"
                                            value="{{ old('deadline') }}">
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
