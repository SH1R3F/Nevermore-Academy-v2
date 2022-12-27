@extends('layouts.guest')

@section('title', '2 factor authentication verification')

@section('content')
    <section>
        <div class="page-header min-vh-100">
            <div class="container">
                <div class="row">
                    <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
                        <div class="card card-plain">
                            <div class="card-header pb-0 text-start">
                                <h4 class="font-weight-bolder">Verify</h4>
                                <p class="mb-0">Enter the code that's sent to you via {{ Session::get('2fa_choice') }}</p>
                            </div>
                            @if (Session::has('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif

                            <div class="card-body">
                                <form role="form" method="POST" action="{{ route('2fa.verify') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <input name="code" type="number" class="form-control form-control-lg"
                                            placeholder="Verification code, Ex: 123456" value="{{ old('code') }}">
                                        @error('code')
                                            <span class="text-danger text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="text-center">
                                        <button type="submit"
                                            class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">Verify</button>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer text-center pt-0 px-lg-2 px-1">
                                <p class="mb-4 text-sm mx-auto">
                                    Didn't receive a code?
                                    <a href="{{ route('2fa.resend') }}"
                                        class="text-primary text-gradient font-weight-bold">Resend</a>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div
                        class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
                        <div class="position-relative bg-gradient-dark h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden"
                            style="background-image: url('{{ asset('assets/img/nevermore.webp') }}');
          background-size: cover;">
                            <span class="mask bg-gradient-dark opacity-6"></span>
                            <h4 class="mt-5 text-white font-weight-bolder position-relative">"Academic institution that
                                nurtures outcasts"
                            </h4>
                            <p class="text-white position-relative">Nevermore is a safe haven for our students to learn and
                                grow no matter who they are.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
