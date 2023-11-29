@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Data Siswa Magang') }}
                    <!-- <button type="button" class="float-right btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                        Permohonan Data Magang Siswa
                    </button> -->
                </div>
                <div class="card-body">
                    <form action="/pegawai/cari" method="GET">
                        <input type="text" name="cari" placeholder="Cari Pegawai .." value="{{ old('cari') }}">
                        <input type="submit" value="CARI">
                    </form>

                    @if(Session::has('success'))
                    <div class="alert alert-success">
                        {{ Session::get('success') }}
                    </div>
                    @elseif (Session::has('error'))
                    <div class="alert alert-danger">
                        {{ Session::get('error') }}
                    </div>
                    @endif

                    <div class="table-responsive">

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">NISN</th>
                                    <th class="text-center">Siswa</th>
                                    <th class="text-center">Guru Pembimbing</th>
                                    <th class="text-center">Nama Perusahaan</th>
                                    <th class="text-center">Periode Magang</th>
                                    <th class="text-center">Detail</th>

                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1 @endphp
                                @foreach ($magang as $ma)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td class="text-capitalize">{{ $ma->siswa->nisn }}</td>
                                    <td class="text-capitalize">{{ $ma->siswa->nama }}</td>
                                    <td>{{ !empty ($ma->guru->nama) ? $ma->guru->nama : '-' }}</td>
                                    <td>{{ $ma->namaperusahaan }}</td>
                                    <td>{{ !empty($ma->awalmagang) ? date('d-m-Y', strtotime($ma->awalmagang)) : '-' }} / {{ !empty($ma->akhirmagang) ? date('d-m-Y', strtotime($ma->akhirmagang)) : '-' }}</td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-info">
                                            <a href="{{ route('guru.bimbingan-siswa', ['id' => $ma->id]) }}">Tampilkan Bimbingan</a>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>


                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection