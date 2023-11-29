@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{'Progress Bimbingan'}}
                    <a href="{{ route('admin.sidang-siswa') }}" class="float-right btn btn-sm btn-success">Kembali</a>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('admin.jadwal-sidang.update', ['id' => $sidang->id]) }}" class="row g-3">
                        @csrf
                        {{ method_field('PUT') }}
                        <div class="col-md-12">
                            <div class="mb-3 row">
                                <label for="siswa" class="col-sm-4 col-form-label">Nama Siswa</label>
                                <div class="col-sm-8">
                                    <input type="text" id="siswa" name="" class="form-control text-capitalize" value="{{$sidang->magang->siswa->nisn}} - {{$sidang->magang->siswa->nama}}" placeholder="" readonly>
                                    <!-- Jika Anda ingin inputnya hanya untuk baca saja (readonly) -->
                                    @if($errors->has('siswa'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('siswa') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="guru" class="col-sm-4 col-form-label">Guru Pembimbing</label>
                                <div class="col-sm-8">
                                    <input type="text" id="guru" name="" class="form-control text-capitalize" value="{{$sidang->magang->guru->nuptk}} - {{$sidang->magang->guru->nama}}" placeholder="" readonly>
                                    <!-- Jika Anda ingin inputnya hanya untuk baca saja (readonly) -->
                                    @if($errors->has('guru'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('guru') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="namaperusahaan" class="col-sm-4 col-form-label">Nama Perusahaan</label>
                                <div class="col-sm-8">
                                    <input type="text" id="namaperusahaan" name="" class="form-control text-capitalize" value="{{$sidang->magang->namaperusahaan}}" placeholder="" readonly>
                                    <!-- Jika Anda ingin inputnya hanya untuk baca saja (readonly) -->
                                    @if($errors->has('namaperusahaan'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('namaperusahaan') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="jadwal_sidang" class="col-sm-4 col-form-label">Jadwal Sidang</label>
                                <div class="col-sm-8">
                                    <input type="date" id="jadwal_sidang" name="jadwal_sidang" class="form-control text-capitalize" value="{{$sidang->magang->namaperusahaan}}">
                                    <!-- Jika Anda ingin inputnya hanya untuk baca saja (readonly) -->
                                    @if($errors->has('jadwal_sidang'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('jadwal_sidang') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="penguji" class="col-sm-4 col-form-label">Penguji</label>
                                <div class="col-sm-8">
                                    <select class="form-control" name="penguji" id="penguji" onchange="checkIfOthers()">
                                        <option value="">- Pilih Penguji</option>
                                        @foreach ($guru as $g)
                                        <option value="{{ $g->nama }}"> {{ $g->nuptk }} - {{ $g->nama}}</option>
                                        @endforeach
                                        <option value="others">Others</option>
                                    </select>
                                    <!-- Jika Anda ingin inputnya hanya untuk baca saja (readonly) -->
                                    @if($errors->has('penguji'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('penguji') }}</strong>
                                    </span>
                                    @endif
                                </div>


                            </div>
                            <div class="mb-3 row">
                            <label for="penguji" class="col-sm-4 col-form-label"></label>
                                <div class="float-right col-sm-8" id="othersInput" style="display: none;">
                                    <input type="text" class="form-control" id="otherPenguji" name="otherPenguji" placeholder="Nama Penguji">
                                </div>
                                @if($errors->has('otherPenguji'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('otherPenguji') }}</strong>
                                </span>
                                @endif
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


<script>
    function checkIfOthers() {
        var select = document.getElementById("penguji");
        var otherInput = document.getElementById("othersInput");

        if (select.value === "others") {
            otherInput.style.display = "block";
        } else {
            otherInput.style.display = "none";
        }
    }
</script>
@endsection