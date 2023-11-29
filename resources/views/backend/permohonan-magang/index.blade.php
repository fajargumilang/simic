@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __(' Permohonan Magang') }}
                    @if ($permohonan_magang->where('status', 2)->count() == 0 && $permohonan_magang->where('status', 1)->count() == 0 && Auth::check())
                    <a href="{{ route('permohonan-magang.add') }}" class="float-right btn btn-sm btn-primary">Ajukan Permohonan </a>
                    @else
                    <a style="cursor:not-allowed" class="float-right btn btn-sm btn-secondary" disabled>Ajukan Permohonan </a>
                    @endif


                </div>
                <div class="card-body">
                    @if(Session::has('success'))
                    <div class="alert alert-success">
                        {{ Session::get('success') }}
                    </div>
                    @endif
                    @if(Session::has('error'))
                    <div class="alert alert-danger">
                        {{ Session::get('error') }}
                    </div>
                    @endif
                    <div class="table-responsive">
                        @if ($permohonan_magang->count() == 0)
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Siswa</th>
                                    <th class="text-center">Nama Perusahaan</th>
                                    <th class="text-center">Periode Magang</th>
                                    <th class="text-center">File Upload</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="7" class="text-center"> TIDAK ADA DATA PERMOHONAN MAGANG</td>
                                </tr>
                            </tbody>
                        </table>
                        @else
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Siswa</th>
                                    <th class="text-center">Guru pembimbing</th>
                                    <th class="text-center">Nama Perusahaan</th>
                                    <th class="text-center">Periode Magang</th>
                                    <th class="text-center">File Upload</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $no = 1;
                                @endphp
                                @foreach ($permohonan_magang as $pm)
                                <tr>
                                    <td class="text-center">{{ $no++ }}</td>
                                    <td class="text-capitalize">{{ $pm->siswa->nama }}</td>
                                    <td class="text-capitalize text-center">{{ !empty ($pm->guru->nama) ? $pm->guru->nama : '-' }}</td>
                                    <td>{{ $pm->namaperusahaan }}</td>
                                    <td class="text-center">{{ !empty ($pm->awalmagang) ? date('d-m-Y', strtotime($pm->awalmagang)) : '-' }} / {{ !empty ($pm->akhirmagang) ? date('d-m-Y', strtotime($pm->akhirmagang)) : '-' }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('file.preview', ['id' => $pm->id]) }}" target="_blank">Tampilkan PDF</a>
                                    </td>

                                    @if ($pm->status == 2 )
                                    <td class="text-center" style="color:orange">Menunggu Persetujuan </td>
                                    <td class="text-center">
                                        <form action="{{ route('permohonan-magang.destroy', ['id' => $pm->id]) }}" method="post" class="d-inline" onsubmit="return confirm('Yakin hapus permohonan magang?')">
                                            @method('delete')
                                            @csrf
                                            <button class="btn btn-danger btn-sm">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                    @elseif ($pm->status == 1)
                                    <td style="color:green" class="text-center">Disetujui</td>
                                    <td class="text-center">
                                        <a href="" class="btn btn-sm btn-info" disabled>
                                            <i class="fa fa-file-text-o"></i>
                                        </a>
                                        <!-- <form action="{{ route('permohonan-magang.destroy', ['id' => $pm->id]) }}" method="post" class="d-inline" onsubmit="return confirm('Yakin hapus permohonan magang?')">
                                            @method('delete')
                                            @csrf
                                            <button class="btn btn-danger btn-sm">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form> -->
                                    </td>
                                    @elseif ($pm->status == 3)
                                    <td style="color:red;" class="text-center">Ditolak</td>
                                    <td class="text-center">
                                        <a href="" class="disabled not-allowed btn btn-sm btn-secondary" disabled>
                                            <i class="fa fa-pencil-square-o"></i>
                                        </a>
                                        </form>
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="note">
                            <small>Note: Jika sudah Disetujui, dan sudah di tentukan Guru Pembimbing oleh Staff TU. Pindah Ke Halaman
                                <a href="{{ route('siswa.bimbingan') }}" class="btn btn-sm btn-link"> "Bimbingan Laporan Prakerin"</a>

                            </small>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection