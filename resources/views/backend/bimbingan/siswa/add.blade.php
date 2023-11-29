@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{'Siswa Bimbingan'}}
                    <a href="{{ route('siswa.bimbingan') }}" class="float-right btn btn-sm btn-success">Kembali</a>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('siswa.bimbingan.store') }}" class="row g-3" enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-12">
                            <div class="mb-3 row">
                                <label for="siswa" class="col-sm-4 col-form-label">Nama Siswa</label>
                                <div class="col-sm-8">
                                    <input type="text" id="siswa" name="" class="form-control text-capitalize" value="{{ Auth::user()->siswa->nisn }} - {{ Auth::user()->siswa->nama }} - {{ Auth::user()->siswa->jurusan->jurusan }}" placeholder="" readonly>
                                    <!-- Jika Anda ingin inputnya hanya untuk baca saja (readonly) -->
                                    @if($errors->has('siswa'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('siswa') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="akhirmagang" class="col-sm-4 col-form-label">File Bimbingan</label>
                                <div class="col-sm-8">
                                    <input type='file' name='file_upload' class="form-control" value='Kirim' />
                                    @if($errors->has('file_upload'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('file_upload') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="komentar" class="col-sm-4 col-form-label">Komentar</label>
                                <div class="col-sm-8">
                                    <textarea type="date" id="komentar" name="komentar" class="form-control" value="{{ old('komentar') }}" placeholder="isikan apa yang sudah di ubah dalam file laporan bimbingan, contoh : BAB 1 - Latar Belakang"></textarea>
                                    @if($errors->has('komentar'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('komentar') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                        </div>

                        <div class="col-12">
                            <input type="submit" class="float-right btn mt-4 btn-primary" value="Simpan">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection