@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Data Magang') }}
                    <!-- <button type="button" class="float-right btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                        Permohonan Data Magang Siswa
                    </button> -->
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        @if ($magang->count() == 0)
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Siswa</th>
                                    <th class="text-center">Guru Pembimbing</th>
                                    <th class="text-center">Nama Perusahaan</th>
                                    <th class="text-center">Periode Magang</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="6" class="text-center">TIDAK ADA DATA MAGANG SISWA</td>
                                </tr>
                            </tbody>
                        </table>
                        @else
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Siswa</th>
                                    <th class="text-center">Guru Pembimbing</th>
                                    <th class="text-center">Nama Perusahaan</th>
                                    <th class="text-center">Periode Magang</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1 @endphp
                                @foreach ($magang as $ma)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td class="text-capitalize">{{ $ma->siswa->nama }}</td>
                                    <td>{{ $ma->guru->nama }}</td>
                                    <td>{{ $ma->namaperusahaan }}</td>
                                    <td>{{ !empty ($ma->awalmagang) ? date('d-m-Y', strtotime($ma->awalmagang)) : '-' }} / {{ !empty ($ma->akhirmagang) ? date('d-m-Y', strtotime($ma->akhirmagang)) : '-' }}</td>
                                    <td class="text-center">
                                        <a href="{{ url('/datapegawai/edit/'.$ma->id) }}" class="btn btn-sm btn-success">
                                            <i class="fa fa-pencil-square-o"></i>
                                        </a>
                                        <form action="{{ route('guru_delete', ['id' => $ma->id]) }}" method="post" class="d-inline" onsubmit="return confirm('Yakin hapus data magang ' + '{{ ucwords($ma->siswa->nama) }}' + ' ?')">

                                            @method('delete')
                                            @csrf
                                            <button class="btn btn-danger btn-sm">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
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


<!-- MODAL -->
<!-- <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Permohonan Data Magang Siswa</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Understood</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div> -->