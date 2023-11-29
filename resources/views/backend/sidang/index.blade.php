@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{ __(' Data Sidang Magang Siswa') }}
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
                        @if ($sidang->count() == 0)
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">NISN</th>
                                    <th class="text-center">Siswa</th>
                                    <th class="text-center">Guru Pembimbing</th>
                                    <th class="text-center">Nama Perusahaan</th>
                                    <th class="text-center">Jadwal Sidang</th>
                                    <th class="text-center">Penguji</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="8" class="text-center"> TIDAK ADA DATA SIDANG SISWA</td>
                                </tr>
                            </tbody>
                        </table>
                        @else
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">NISN</th>
                                    <th class="text-center">Siswa</th>
                                    <th class="text-center">Guru Pembimbing</th>
                                    <th class="text-center">Nama Perusahaan</th>
                                    <th class="text-center">Jadwal Sidang</th>
                                    <th class="text-center">Penguji</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $no = 1;
                                @endphp
                                @foreach ($sidang as $sid)
                                <tr>
                                    <td class="text-center">{{ $no++ }}</td>
                                    <td class="text-capitalize">{{ $sid->magang->siswa->nisn }}</td>
                                    <td class="text-capitalize">{{ $sid->magang->siswa->nama }}</td>
                                    <td class="text-capitalize">{{ $sid->magang->guru->nama }}</td>
                                    <td class="text-capitalize">{{ $sid->magang->namaperusahaan }}</td>
                                    <td class="text-capitalize">{{ !empty ($sid->jadwal_sidang) ? date('d-m-Y', strtotime($sid->jadwal_sidang)) : '-' }}</td>
                                    <td class="text-capitalize">{{ $sid->penguji }}</td>
                                    <td class="text-center">
                                        @if ($sid->penguji == null)
                                        <button class="btn btn-sm btn-info open-modal" data-toggle="modal" id="idSidang" data-target="#sidangModal" data-sidangid="{{ $sid->id }}">
                                            <i class="fa fa-calendar-plus-o"></i>
                                        </button>
                                        @else
                                        <a href="{{ route('admin.jadwal-sidang.edit', ['id' => $sid->id]) }}" class="btn btn-sm btn-success">
                                            <i class="fa fa-pencil-square-o"></i>
                                        </a>
                                        @endif
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



<script>
    document.querySelectorAll(".open-modal").forEach(function(button) {
        button.addEventListener("click", function() {
            var sidangId = this.getAttribute("data-sidangid");
            var modal = new bootstrap.Modal(document.getElementById("sidangModal"));
            modal.show();

            // Simpan ID bimbingan ini dalam elemen dengan ID "idBimbingan"
            document.getElementById("idSidang").dataset.sidangid = sidangId;
        });
    });
</script>

<!-- Modal Setujui -->
<div class="modal fade" id="sidangModal" tabindex="-1" role="dialog" aria-labelledby="sidangModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sidangModalLabel">Atur Jadwal Sidang </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="siswaNama">Nama Siswa</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <input type="text" id="" name="" class="form-control text-capitalize" value="{{ $sid->magang->siswa->nisn }} - {{ $sid->magang->siswa->nama }}" placeholder="" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="siswaNama">Guru Pembimbing</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <input type="text" id="" name="" class="form-control text-capitalize" value="{{ $sid->magang->guru->nuptk }} - {{ $sid->magang->guru->nama }}" placeholder="" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="siswaNama">Nama Perusahaan</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <input type="text" id="siswa" name="" class="form-control text-capitalize" value="{{ $sid->magang->namaperusahaan }}" placeholder="" readonly>
                    </div>
                </div>

                <form id="sidangForm">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="siswaNama"><b>Jadwal Sidang</b></label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <input type="date" class="form-control" id="jadwal" name="jadwal" placeholder="Tentukan jadwal"></input>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="siswaNama"><b>Penguji</b></label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <select class="form-control" id="penguji" name="penguji" onchange="checkIfOthers()">
                                <option value="">- Pilih Penguji</option>
                                @foreach ($guru as $g)
                                <option value="{{ $g->nama }}">{{ $g->nuptk }} - {{ $g->nama }}</option>
                                @endforeach
                                <option value="others">Others</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                        </div>

                        <div class="float-right col-md-6" id="othersInput" style="display: none;">
                            <input type="text" class="form-control" id="otherPenguji" name="otherPenguji" placeholder="Nama Penguji">
                        </div>
                    </div>
                    <!-- Formulir persetujuan -->
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-success" onclick="jadwalSidang()">Setujui</button>
            </div>
        </div>
    </div>
</div>

<script>
    function jadwalSidang() {
        var sidangId = $("#idSidang").data("sidangid");
        var Jadwal = $('#jadwal').val();
        var Penguji = $('#penguji').val();
        var otherPenguji = $('#otherPenguji').val();

        if (!Penguji || !Jadwal) {
            // Handle jika pengguna belum memilih guru atau jika tidak ada ID magang
            alert('Silahkan isi formulir terlebih dahulu');
            return; // Keluar dari fungsi untuk mencegah pengiriman data yang tidak valid
        }

        $.ajax({
            type: 'POST',
            url: '/admin/sidang/jadwal/' + sidangId,
            data: {
                _token: '{{ csrf_token() }}',
                jadwal: Jadwal,
                penguji: Penguji,
                otherPenguji: otherPenguji
            },
            success: function(data) {
                // Handle jika simpan berhasil
                // Tampilkan notifikasi
                alert('Berhasil disetujui ');

                // Refresh halaman
                location.reload();
            },
            error: function(error) {
                // Handle jika terjadi kesalahan saat menyimpan
                // Tampilkan notifikasi kesalahan
                alert('Terjadi kesalahan.');
            }
        });
        // Tutup modal
        $("#sidangModal").modal('hide');
    }
</script>

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