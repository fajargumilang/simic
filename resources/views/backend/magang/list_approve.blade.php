@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{ __('Data Permohonan Magang') }}
                    <a href="{{ route('magang.index') }}" class="float-right btn btn-sm btn-success">Kembali</a>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        @if ($permohonan_magang->count() == 0)
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Siswa</th>
                                    <th class="text-center">Nama Perusahaan</th>
                                    <th class="text-center">Periode Magang</th>
                                    <th class="text-center">File Upload</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="6" class="text-center"> TIDAK ADA DATA PERMOHONAN MAGANG</td>
                                </tr>
                            </tbody>
                        </table>
                        @else
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Siswa</th>
                                    <th class="text-center">Nama Perusahaan</th>
                                    <th class="text-center">Periode Magang</th>
                                    <th class="text-center">File Upload</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $no = 1;
                                @endphp
                                @foreach ($permohonan_magang as $pm)
                                <tr>
                                    <td class="text-center">{{ $no++ }}</td>
                                    <td class="text-center text-capitalize">{{ $pm->siswa->nama }}</td>
                                    <td class="text-center">{{ $pm->namaperusahaan }}</td>
                                    <td class="text-center">{{ !empty ($pm->awalmagang) ? date('d-m-Y', strtotime($pm->awalmagang)) : '-' }} / {{ !empty ($pm->akhirmagang) ? date('d-m-Y', strtotime($pm->akhirmagang)) : '-' }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.file-preview', ['id' => $pm->id]) }}" target="_blank">Tampilkan PDF</a>
                                    </td>
                                    @if ($pm->status == 2 )
                                    <td class="text-center">
                                        <form action="{{ route('magang.approve', ['id' => $pm->id]) }}" method="post" class="d-inline" onsubmit="return confirm('Yakin menyetujui permohonan magang ' + '{{ ucwords($pm->siswa->nama) }}' + ' ?')">
                                            @csrf
                                            <button type="submit" class="ml-2 btn btn-sm btn-success">
                                                <i class="fa fa-check"></i>
                                            </button>
                                        </form>

                                        <form action="{{ route('magang.reject', ['id' => $pm->id]) }}" method="post" class="d-inline" onsubmit="return confirm('Yakin menolak permohonan magang ' + '{{ ucwords($pm->siswa->nama) }}' + ' ?')">
                                            @csrf
                                            <button type="submit" class="ml-2 btn btn-sm btn-danger">
                                                <i class="fa fa-close"></i>
                                            </button>
                                        </form>
                                    </td>
                                    @elseif ($pm->status == 1)
                                    <td style="color:green" class="text-center">Disetujui </td>
                                    @elseif ($pm->status == 3)
                                    <td style="color:red;" class="text-center">Ditolak</td>
                                    @endif

                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection