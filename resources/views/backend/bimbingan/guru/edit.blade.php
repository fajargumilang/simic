@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{'Progress Bimbingan'}}
                    <a href="{{ URL::previous() }}" class="float-right btn btn-sm btn-success">Kembali</a>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('guru.respon-bimbingan.update', ['id' => $bimbingan->id]) }}" class="row g-3">
                        @csrf
                        {{ method_field('PUT') }}
                        <div class="col-md-12">
                            <div class="mb-3 row">
                                <label for="siswa" class="col-sm-4 col-form-label">Nama Siswa</label>
                                <div class="col-sm-8">
                                    <input type="text" id="siswa" name="" class="form-control text-capitalize" value="{{$bimbingan->magang->siswa->nama}}" placeholder="" readonly>
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
                                    <a id="siswa" name="" class="form-control text-left btn btn-sm btn-link" href="{{ route('guru.file-preview', ['id' => $bimbingan->id]) }}" target="_blank" readonly>Tampilkan File</a>

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
                                    <input type="text" id="siswa" name="" class="form-control text-capitalize" value="{{$bimbingan->komentar}}" placeholder="" readonly>

                                    @if($errors->has('komentar'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('komentar') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="komentar" class="col-sm-4 col-form-label">Status</label>
                                <div class="col-sm-8">
                                    <select name="status" id="" class="form-control">
                                        <option value="1" {{ $bimbingan->status == 1 ? 'selected' : '' }}>Disetujui</option>
                                        <option value="3" {{ $bimbingan->status == 3 ? 'selected' : '' }}>Ditolak</option>
                                    </select>

                                    @if($errors->has('komentar'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('komentar') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="respon" class="col-sm-4 col-form-label">Respon Pembimbing</label>
                                <div class="col-sm-8">
                                    <textarea type="text" id="respon" name="respon" class="form-control" value="{{ old('respon') }}" placeholder="Respon Pembimbing"> {{$bimbingan->respon}}</textarea>
                                    @if($errors->has('respon'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('respon') }}</strong>
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