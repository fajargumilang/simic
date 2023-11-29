@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <div class="container alert alert-success">
                        <h3><b>
                            Selamat Datang
                            <span class="text-capitalize">
                                {{ Auth::user()->siswa->nama ?? Auth::user()->guru->nama ?? 'super admin' }}!</span>
                        </b></h3>
                        <p>Tentukan Perusahaan untuk dijadikan Project Magang pada Program Prakerin Informatika Ciputat</p>
                    </div>

                    <div id="carouselExampleAutoplaying" class="carousel slide mx-auto w-75" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="{{ asset('images/cr1.jpeg') }}" class="d-block mx-auto w-75" alt="...">
                                <div class="carousel-caption d-none d-md-block">
                                    <!-- Konten caption, jika diperlukan -->
                                </div>
                            </div>
                            <div class="carousel-item">
                                <img src="{{ asset('images/cr2.jpeg') }}" class="d-block mx-auto w-75" alt="...">
                                <div class="carousel-caption d-none d-md-block">
                                    <!-- Konten caption, jika diperlukan -->
                                </div>
                            </div>
                            <div class="carousel-item">
                                <img src="{{ asset('images/cr3.jpeg') }}" class="d-block mx-auto w-75" alt="...">
                                <div class="carousel-caption d-none d-md-block">
                                    <!-- Konten caption, jika diperlukan -->
                                </div>
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                        <ol class="carousel-indicators">
                            <li data-bs-target="#carouselExampleAutoplaying" data-bs-slide-to="0" class="active"></li>
                            <li data-bs-target="#carouselExampleAutoplaying" data-bs-slide-to="1"></li>
                            <li data-bs-target="#carouselExampleAutoplaying" data-bs-slide-to="2"></li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection