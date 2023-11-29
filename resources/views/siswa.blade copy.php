@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Data Siswa
                    <a href="{{ route('siswa.create') }}" class="float-right btn btn-sm btn-primary">Tambah Data Siswa</a>
                </div>

                <div class="card-body">
                    @if(Session::has('success'))
                    <div class="alert alert-success">
                        {{ Session::get('success') }}
                    </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>

                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">NISN</th>
                                    <th class="text-center">NAMA</th>
                                    <th class="text-center">ANGKATAN</th>
                                    <th class="text-center">NO HP</th>
                                    <th class="text-center">JENIS KELAMIN</th>
                                    <th class="text-center">TANGGAL LAHIR</th>
                                    <th class="text-center">AGAMA</th>
                                    <th class="text-center">ALAMAT</th>
                                    <th class="text-center">Username Log</th>

                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            @php
                                    $no = 1;
                                    @endphp

                            @foreach ($siswa as $sis)
                            <tbody>
                                <tr>

                                    <td>{{$no++}}</td>
                                    <td>{{$sis->nisn}}</td>
                                    <td class="text-capitalize">{{$sis->nama}}</td>
                                    <td>{{$sis->angkatan}}</td>
                                    <td>{{$sis->no_hp}}</td>
                                    <td>{{$sis->jeniskelamin}}</td>
                                    <td> {{date('d-m-Y', strtotime($sis->tanggal_lahir)) }}</td>
                                    <td>{{$sis->agama_id}}</td>
                                    <td>{{$sis->alamat}}</td>

                                    <td>{{$sis->user->username}}</td>
                                    <td class="text-center">
                                        <a href="{{ url('/datapegawai/edit/'.$sis->id) }}" class="btn btn-sm btn-success">
                                            <i class="fa fa-pencil-square-o"></i>
                                        </a>
                                        <form action="{{ route('guru_delete', ['id' => $sis->id]) }}" method="post" class="d-inline" onsubmit="return confirm('Yakin hapus data pegawai dan juga user login {{$sis->nama}}?')">

                                            @method('delete')
                                            @csrf
                                            <button class="btn btn-danger btn-sm">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            </tbody>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection