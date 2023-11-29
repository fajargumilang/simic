@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Data Guru
                    <a href="{{ route('guru.create') }}" class="float-right btn btn-sm btn-primary">Tambah Data Guru</a>
                </div>

                <div class="card-body">
                    @if(Session::has('success'))
                    <div class="alert alert-success">
                        {{ Session::get('success') }}
                    </div>
                    @elseif(Session::has('error'))
                    <div class="alert alert-danger">
                        {{ Session::get('error') }}
                    </div>
                    @endif
                    <div class="mb-3 row">
                        <div class="col-md-10">
                            <form action="{{ route('guru.search') }}" method="get" class="form-inline mb-3">
                                <input type="text" name="cari" value="<?php if (isset($_GET['cari'])) {
                                                                            echo $_GET['cari'];
                                                                        } ?>" class="form-control" placeholder="Cari ..">
                                <input style="margin-left : 10px;" type="submit" class="btn btn-primary" value="Cari">
                            </form>
                            <form method="GET" action="{{ route('guru.index') }}">
                                <label for="perPage">Items per page:</label>
                                <select name="perPage" id="perPage" onchange="this.form.submit()">
                                    <option value="8" {{ request('perPage') ==  8 ? 'selected' : '' }}>8</option>
                                    <option value="20" {{ request('perPage') == 20 ? 'selected' : '' }}>20</option>
                                    <option value="50" {{ request('perPage') == 50 ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ request('perPage') == 100 ? 'selected' : '' }}>100</option>
                                    <!-- Tambahkan opsi lainnya sesuai kebutuhan -->
                                </select>
                            </form>
                        </div>
                        <div class="col-md-2">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <p1 class="card-title">
                                        <b>TOTAL GURU <span class="float-right">: {{$totalguru}}</b></span></p1>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>

                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">NUPTK</th>
                                    <th class="text-center">NAMA</th>
                                    <th class="text-center">NO HP</th>
                                    <th class="text-center">JENIS KELAMIN</th>
                                    <th class="text-center">TGL LAHIR</th>
                                    <th class="text-center">USER LOGIN</th>

                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            @php
                            $no = 1;
                            @endphp

                            @foreach ($guru as $g)
                            <tbody>
                                <tr>

                                    <td>{{$no++}}</td>
                                    <td>{{$g->nuptk}}</td>
                                    <td class="text-uppercase">{{$g->nama}}</td>
                                    <td>{{!empty($g->no_hp) ? $g->no_hp : '-'}}</td>
                                    <td>{{$g->jeniskelamin}}</td>
                                    <td> {{date('d-m-Y', strtotime($g->tanggal_lahir)) }}</td>

                                    <td>{{$g->user->username}}</td>
                                    <td class="text-center">
                                        <a href="{{ url('/guru/edit/'.$g->id) }}" class="btn btn-sm btn-success">
                                            <i class="fa fa-pencil-square-o"></i>
                                        </a>
                                        <form action="{{ route('guru.destroy', ['id' => $g->id]) }}" method="post" class="d-inline" onsubmit="return confirm('Yakin hapus data pegawai dan juga user login {{$g->nama}}?')">
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
                        {{ $guru->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection