@extends('layouts.guest')

@section('title', 'Sign up')

@section('content')
    <div class="page-header align-items-start min-vh-50 pt-5 pb-11 m-3 border-radius-lg"
        style="background-image: url('{{ asset('assets/img/nevermore.webp') }}'); background-position: center;">
        <span class="mask bg-gradient-dark opacity-6"></span>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5 text-center mx-auto">
                    <h1 class="text-white mb-2 mt-5">Welcome!</h1>
                    <p class="text-lead text-white">Nevermore is a safe haven for our students to learn and
                        grow no matter who they are.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row mt-lg-n10 mt-md-n11 mt-n10 justify-content-center">
            <div class="col-xl-4 col-lg-5 col-md-7 mx-auto">
                <div class="card z-index-0">
                    <div class="card-body">
                        <form role="form" method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="mb-3">
                                <input name="name" type="text" class="form-control" placeholder="Name"
                                    aria-label="Name">
                                @error('name')
                                    <span class="text-danger text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <input name="email" type="email" class="form-control" placeholder="Email"
                                    aria-label="Email">
                                @error('email')
                                    <span class="text-danger text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <input name="password" type="password" class="form-control" placeholder="Password"
                                    aria-label="Password">
                                @error('password')
                                    <span class="text-danger text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <input name="password_confirmation" type="password" class="form-control"
                                    placeholder="Confirm password" aria-label="Password">
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn bg-gradient-dark w-100 my-4 mb-2">Sign up</button>
                            </div>
                            <p class="text-sm mt-3 mb-0">Already have an account? <a href="{{ route('login') }}"
                                    class="text-dark font-weight-bolder">Sign in</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
