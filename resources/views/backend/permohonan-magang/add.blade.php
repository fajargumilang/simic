@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Tambah Permohonan Magang
                    <a href="{{ route('permohonan-magang.index') }}" class="float-right btn btn-sm btn-success">Kembali</a>
                </div>
                <div class="card-body">


                    <form method="post" action="{{ route('permohonan-magang.store') }}" class="row g-3" enctype="multipart/form-data">
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

                            <!-- <div class="mb-3 row">
                                <label for="judulmagang" class="col-sm-4 col-form-label">Guru Pembimbing</label>
                                <div class="col-sm-8">
                                    <select type="text" id="guru" name="guru" class="form-control" value="{{ old('guru') }}">
                                        <option value="">- Pilih Guru Pembimbing</option>
                                        @foreach ($guru as $g)
                                        <option value="{{$g->id}}"> {{$g->nama}}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('guru'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('guru') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div> -->

                            <div class="mb-3 row">
                                <label for="namaperusahaan" class="col-sm-4 col-form-label">Nama Perusahaan</label>
                                <div class="col-sm-8">
                                    <input type="text" id="namaperusahaan" name="namaperusahaan" class="form-control" value="{{ old('namaperusahaan') }}">
                                    @if($errors->has('namaperusahaan'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('namaperusahaan') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="awalmagang" class="col-sm-4 col-form-label">Tanggal Mulai</label>
                                <div class="col-sm-8">
                                    <input type="date" id="awalmagang" name="awalmagang" class="form-control" value="{{ old('awalmagang') }}">
                                    @if($errors->has('awalmagang'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('awalmagang') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="akhirmagang" class="col-sm-4 col-form-label">Tanggal Selesai</label>
                                <div class="col-sm-8">
                                    <input type="date" id="akhirmagang" name="akhirmagang" class="form-control" value="{{ old('akhirmagang') }}">
                                    @if($errors->has('akhirmagang'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('akhirmagang') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="akhirmagang" class="col-sm-4 col-form-label">Surat Balasan Perusahaan</label>
                                <div class="col-sm-8">
                                    <input type='file' name='file_upload' class="form-control" value='Kirim' />
                                    @if($errors->has('file_upload'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('file_upload') }}</strong>
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