@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Tambah Data Guru
                    <a href="{{ route('guru.index') }}" class="float-right btn btn-sm btn-success">Kembali</a>
                </div>
                <div class="card-body">
                    @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @elseif (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                    @endif

                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <form method="post" action="{{ route('guru.store') }}" class="row g-3">
                                @csrf
                                <div class="form-floating col-md-12">
                                    <input type="text" name="nuptk" class="form-control" id="floatingNUPTK" value="{{ old('nuptk') }}" placeholder="" autofocus>
                                    <label for="floatingNUPTK" class="form-label">NUPTK</label>
                                    @if($errors->has('nuptk'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('nuptk') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-floating col-md-12">
                                    <input type="text" name="nama" id="floatingNama" class="form-control" value="{{ old('nama') }}" placeholder="">
                                    <label for="floatingNama">Nama</label>
                                    @if($errors->has('nama'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('nama') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <!-- ... -->
                                <!-- Kolom No Hp -->

                                <div class="form-floating col-md-12">
                                    <input type="number" class="form-control" min="0" name="no_hp" id="floatingNoHP" placeholder="082xxxxxx" value="{{ old('no_hp') }}">
                                    <label for="floatingNoHP">No HP</label>
                                </div>
                                <!-- ... -->
                                <!-- Kolom Jenis Kelamin -->

                                <div class="form-floating col-md-12">
                                    <select name="jeniskelamin" class="form-select" id="floatingJK" value="{{ old('jeniskelamin') }}">
                                        <option value="">- Pilih Jenis Kelamin</option>
                                        <option value="Laki-laki">Laki-Laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                    <label for="floatingJK">Jenis Kelamin</label>
                                    @if($errors->has('jeniskelamin'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('jeniskelamin') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <!-- ... -->
                                <!-- Kolom Tanggal Lahir -->

                                <div class="form-floating col-md-12">
                                    <input type="date" class="form-control" id="floatingTL" name="tanggal_lahir" name="tanggal_lahir">
                                    <label for="floatingTL">Tanggal Lahir</label>
                                    @if($errors->has('tanggal_lahir'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('tanggal_lahir') }}</strong>
                                    </span>
                                    @endif
                                </div>
                        </div>
                        <!-- ... -->
                        <!-- ... -->
                        <!-- Kolom Username Login -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body row g-3">
                                    <div class="text-center"><b>-= CREATE USER LOGIN =-</b></div>

                                    <div class="form-floating col-md-12">
                                        <input id="username" placeholder="" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username">
                                        <label for="username" class="form-label">Username Login</label>
                                        @error('username')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-floating col-md-12">
                                        <input id="password" type="password" placeholder="" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                        <label for="password">Password</label>
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-floating col-md-12">
                                        <input id="password-confirm" placeholder="" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                        <label for="password-confirm" class="form-label">{{ __('Confirm Password') }}</label>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-12">
                                <input type="submit" class="btn mt-2 btn-primary" value="Simpan">
                            </div>
                        </div>
                    </div>
                    <!-- ... -->
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection