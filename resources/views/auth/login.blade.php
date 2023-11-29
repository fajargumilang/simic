@extends('layouts.app')

@section('content')

<div class="content">
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="container">
            <div class="row">
                <div class="col-md-6 order-md-2">
                    <img src="images/undraw_file_sync_ot38.svg" alt="Image" class="img-fluid">
                </div>
                <div class="col-md-6 contents">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="mb-4">
                               
                                <h3> <img src="images/logoic.jpeg" alt="Image" width="10%" class="img-fluid">Login <strong>SIMIC</strong></h3>
                                <p class="mb-4">Sistem Informasi Magang SMK Informatika Ciputat</p>
                            </div>
                            <form action="#" method="post">
                                <div class="form-floating form-group first">
                                    <input id="username" id="username" placeholder="" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>
                                    <label for="username" >Username</label>
                                    @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-floating form-group last mb-4">
                                    <input id="password" type="password" id="password" placeholder="" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                    <label for="password">Password</label>
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="d-flex mb-5 align-items-center">
                                    <label class="control control--checkbox mb-0"><span class="caption">Remember me</span>
                                        <input type="checkbox" checked="checked" />
                                        <div class="control__indicator"></div>
                                    </label>

                                    @if (Route::has('password.request'))
                                    <span class="ml-auto"><a class="forgot-pass" href="{{ route('password.request') }}">
                                            {{ __('Forgot Password') }}
                                        </a> </span>
                                    @endif
                                </div>

                                <button type="submit" class="btn text-white btn-block btn-primary">
                                    {{ __('Login') }}
                                </button>

                            </form>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </form>
</div>
@endsection