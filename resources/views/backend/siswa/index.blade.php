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
                    @elseif(Session::has('error'))
                    <div class="alert alert-danger">
                        {{ Session::get('error') }}
                    </div>
                    @endif

                    <div class="mb-3 row">
                        <div class="col-md-10">
                            <form action="{{ route('siswa.search') }}" method="get" class="form-inline mb-3">
                                <input type="text" name="cari" value="<?php if (isset($_GET['cari'])) {
                                                                            echo $_GET['cari'];
                                                                        } ?>" class="form-control" placeholder="Cari ..">
                                <input style="margin-left : 10px;" type="submit" class="btn btn-primary" value="Cari">
                            </form>

                            <form method="GET" action="{{ route('siswa.index') }}">
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
                                        <b>TOTAL SISWA <span class="float-right">: {{$totalsiswa}}</b></span>
                                    </p1>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="table-responsive">
                        <table id="myTable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center" onclick="sortTable(0)">NISN <span id="icon-0"></span></th>
                                    <th class="text-center" onclick="sortTable(1)">NAMA <span id="icon-1"></span></th>
                                    <th class="text-center" onclick="sortTable(2)">JURUSAN <span id="icon-2"></span></th>
                                    <th class="text-center" onclick="sortTable(3)">ANGKATAN <span id="icon-3"></span></th>
                                    <th class="text-center" onclick="sortTable(4)">NO HP <span id="icon-4"></span></th>
                                    <th class="text-center" onclick="sortTable(5)">JENIS KELAMIN <span id="icon-5"></span></th>
                                    <th class="text-center" onclick="sortTable(6)">TGL LAHIR <span id="icon-6"></span></th>
                                    <th class="text-center" onclick="sortTable(7)">USER LOGIN <span id="icon-7"></span></th>

                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            @php
                            $no = 1;
                            @endphp

                            <tbody>
                                @foreach ($siswa as $sis)
                                <tr>
                                    <td>{{$no++}}</td>
                                    <td>{{$sis->nisn}}</td>
                                    <td class="text-uppercase">{{$sis->nama}}</td>
                                    <td>{{$sis->jurusan->jurusan}}</td>
                                    <td>{{$sis->tahun_awal}} / {{$sis->tahun_akhir}}</td>
                                    <td>{{$sis->no_hp}}</td>
                                    <td>{{$sis->jeniskelamin}}</td>
                                    <td> {{date('d-m-Y', strtotime($sis->tanggal_lahir)) }}</td>
                                    <td>{{$sis->user->username}}</td>
                                    <td class="text-center">
                                        <a href="{{ url('/guru/edit/'.$sis->id) }}" class="btn btn-sm btn-success">
                                            <i class="fa fa-pencil-square-o"></i>
                                        </a>
                                        <form action="{{ route('siswa.destroy', ['id' => $sis->id]) }}" method="post" class="d-inline" onsubmit="return confirm('Yakin hapus data pegawai dan juga user login {{$sis->nama}}?')">
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
                        {{ $siswa->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var currentOrder = 'asc'; // Urutan saat ini (asc atau desc)
    var currentColumn = ''; // Kolom saat ini yang diurutkan

    function sortTable(column) {
        var table, rows, switching, i, x, y, shouldSwitch;
        table = document.getElementById("myTable");
        switching = true;

        if (currentColumn === column) {
            currentOrder = currentOrder === 'asc' ? 'desc' : 'asc';
        } else {
            currentOrder = 'asc';
            currentColumn = column;
        }

        updateIcons(); // Tambahkan pemanggilan fungsi untuk memperbarui ikon

        while (switching) {
            switching = false;
            rows = table.rows;

            for (i = 1; i < rows.length - 1; i++) {
                shouldSwitch = false;
                x = rows[i].getElementsByTagName("td")[column].innerHTML;
                y = rows[i + 1].getElementsByTagName("td")[column].innerHTML;

                // Konversi x dan y ke tipe data numerik jika kolom adalah angka
                if (!isNaN(x) && !isNaN(y)) {
                    x = parseFloat(x);
                    y = parseFloat(y);
                }

                if (currentOrder === 'asc' ? x > y : x < y) {
                    shouldSwitch = true;
                    break;
                }
            }

            if (shouldSwitch) {
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
            }
        }
    }

    function updateIcons() {
        // Fungsi untuk memperbarui ikon di semua kolom
        for (var i = 0; i <= 7; i++) {
            var iconElement = document.getElementById("icon-" + i);
            if (iconElement) {
                iconElement.innerHTML = ''; // Kosongkan ikon di semua kolom
            }
        }

        // Tambahkan ikon di kolom saat ini
        var icon = currentOrder === 'asc' ? '&#9650;' : '&#9660;';
        document.getElementById("icon-" + currentColumn).innerHTML = icon;
    }
</script>
@endsection