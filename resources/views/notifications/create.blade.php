@extends('layouts.app')

@section('title', 'Push notification to users')

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
                    <form method="POST" action="{{ route('notifications.store') }}">
                        @csrf
                        <div class="card-header pb-0">
                            <div class="d-flex align-items-center">
                                <p class="mb-0">Push a notification to users</p>
                                <button class="btn btn-primary btn-sm ms-auto">Push</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="text-uppercase text-sm">Notification info</p>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="message" class="form-control-label">message</label>
                                        <input class="form-control" id="message" type="text" name="message"
                                            value="{{ old('message') }}">
                                        @error('message')
                                            <span class="text-danger text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="message" class="form-control-label">Send to</label>
                                        <div>
                                            <label for="superadmin">
                                                <input type="checkbox" id="superadmin" name="recipients[superadmin]">
                                                Superadmins
                                            </label>
                                            <label for="teacher">
                                                <input type="checkbox" id="teacher" name="recipients[teacher]">
                                                Teachers
                                            </label>
                                            <label for="student">
                                                <input type="checkbox" id="student" name="recipients[student]">
                                                Students
                                            </label>
                                        </div>
                                        @error('recipients')
                                            <span class="text-danger text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="message" class="form-control-label">Send via</label>
                                        <div>
                                            <label for="mail">
                                                <input type="checkbox" id="mail" name="via[mail]">
                                                Email
                                            </label>
                                            <label for="database">
                                                <input type="checkbox" id="database" name="via[database]">
                                                In-App notification
                                            </label>
                                            <label for="sms">
                                                <input type="checkbox" id="sms" name="via[sms]">
                                                SMS
                                            </label>
                                        </div>
                                        @error('via')
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
