@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{ __('Progress Bimbingan ') }}
                    <a href="{{route('guru.siswa-bimbingan')}}" class="float-right btn btn-sm btn-success">Kembali</a>
                </div>
                <div class="card-body">
                    @if(Session::has('success'))
                    <div class="alert alert-success">
                        {{ Session::get('success') }}
                    </div>
                    @elseif (Session::has('error'))
                    <div class="alert alert-danger">
                        {{ Session::get('error') }}
                    </div>
                    @endif

                    <div class="row">
                        <!-- Bagian Profil Siswa (Kiri Atas) -->
                        <div class="col-md-6">
                            <div class=" profile-info">
                                <div class="row">

                                    <div class="profile-label"><b>Nama Siswa:</b>
                                        {{ !empty ($magang->siswa->nisn) ? $magang->siswa->nisn : '-' }} - {{ !empty ($magang->siswa->nama) ? $magang->siswa->nama : '-' }}
                                    </div>
                                    <div class="profile-label"><b>Jurusan:</b>
                                        {{ !empty ($magang->siswa->jurusan->jurusan) ? $magang->siswa->jurusan->jurusan : '-' }}
                                    </div>
                                    <div class="profile-label"><b>Tahun Ajaran:</b>
                                        {{ !empty ($magang->siswa->tahun_awal) ? $magang->siswa->tahun_awal : '-' }}/{{ !empty ($magang->siswa->tahun_akhir) ? $magang->siswa->tahun_akhir : '-' }}
                                    </div>
                                    <div class="profile-label"><b>Guru Pembimbing:</b>
                                        {{ !empty ($magang->guru->nuptk) ? $magang->guru->nuptk : '' }} - {{ !empty ($magang->guru->nama) ? $magang->guru->nama : '' }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Bagian Progress (Kanan Bawah) -->
                        <div class="col-md-6">
                            <div for="progressBimbingan" class="text-center mb-2"> Progress Bimbingan</div>
                            <!-- Gunakan progress bar atau metode lain untuk menampilkan kemajuan -->
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" style="width: {{ number_format($progressPercentage, 1) }}%;" aria-valuenow="{{ number_format($progressPercentage, 1) }}" aria-valuemin="0" aria-valuemax="{{ $maxProgress }}">{{ number_format($progressPercentage, 1) }}%</div>
                            </div>
                            <p> Status:<b> {{ $progress_status }}</b></p>
                        </div>

                    </div>

                    <!-- Bagian Tabel File dan Komentar (Bawah Kiri) -->
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">No.</th>
                                    <th class="text-center">File Terlampir</th>
                                    <th class="text-center">Komentar</th>
                                    <th class="text-center">Tanggal Bimbingan</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Respon Pembimbing</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1 @endphp
                                @foreach($bimbingan as $bim)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('guru.file-preview', ['id' => $bim->id]) }}" target="_blank">Tampilkan File</a>
                                    </td>
                                    <td class="text-center">{{ !empty($bim->komentar) ? $bim->komentar : '-' }}</td>
                                    <td class="text-center">{{ !empty($bim->created_at) ? date('d-m-Y', strtotime($bim->created_at)) : '-' }}</td>
                                    @if ($bim->status == 2)
                                    <td class="text-center" style="color:orange">Menunggu Persetujuan</td>
                                    @elseif ($bim->status == 1)
                                    <td class="text-center" style="color:green">Disetujui</td>
                                    @else
                                    <td class="text-center" style="color:red">Ditolak</td>
                                    @endif
                                    @if ($bim->respon == !null)
                                    <td class="text-center"> {{ $bim->respon }}</td>
                                    @else
                                    <td class="text-center">
                                        -
                                    </td>
                                    @endif
                                    <td class="text-center">
                                        @if ($bim->status == 2)
                                        <button class="btn btn-sm btn-success open-modal" data-toggle="modal" id="idBimbingan" data-target="#setujuiModal" data-bimbinganid="{{ $bim->id }}">
                                            <i class="fa fa-check"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger open-modal2" data-toggle="modal" id="idBimbingan2" data-target="#tolakModal" data-bimbinganid2="{{ $bim->id }}">
                                            <i class="fa fa-close"></i>
                                        </button>
                                        @else
                                        <a href="{{ route('guru.respon-pembimbing', ['id' => $bim->id]) }}" class="btn btn-sm btn-success">
                                            <i class="fa fa-pencil-square-o"></i>
                                        </a>
                                        @endif
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


<script>
    document.querySelectorAll(".open-modal").forEach(function(button) {
        button.addEventListener("click", function() {
            var bimbinganId = this.getAttribute("data-bimbinganid");
            var modal = new bootstrap.Modal(document.getElementById("setujuiModal"));
            modal.show();

            // Simpan ID bimbingan ini dalam elemen dengan ID "idBimbingan"
            document.getElementById("idBimbingan").dataset.bimbinganid = bimbinganId;
        });
    });
</script>

<!-- Modal Setujui -->
<div class="modal fade" id="setujuiModal" tabindex="-1" role="dialog" aria-labelledby="setujuiModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="setujuiModalLabel">Persetujuan Bimbingan</h5>
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
                        <input type="text" id="" name="" class="form-control text-capitalize" value="{{ $bim->magang->siswa->nisn }} - {{ $bim->magang->siswa->nama }}" placeholder="" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="siswaNama">komentar</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <input type="text" id="" name="" class="form-control text-capitalize" value="{{ $bim->komentar }}" placeholder="" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="siswaNama">Tgl Bimbingan</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <input type="text" id="" name="" class="form-control text-capitalize" value="{{ date('d-m-Y', strtotime($bim->created_at)) }}" placeholder="" readonly>
                    </div>
                </div>

                <form id="setujuiForm">
                    <!-- Formulir persetujuan -->
                    <textarea class="form-control" id="respon" name="respon" placeholder="Alasan Persetujuan"></textarea>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-success" onclick="setujuiBimbingan()">Setujui</button>
            </div>
        </div>
    </div>
</div>

<script>
    function setujuiBimbingan() {
        var bimbinganId = $("#idBimbingan").data("bimbinganid");
        var alasanPersetujuan = $('#respon').val();

        if (!alasanPersetujuan) {
            // Handle jika pengguna belum memilih guru atau jika tidak ada ID magang
            alert('Silahkan isi alasan terlebih dahulu');
            return; // Keluar dari fungsi untuk mencegah pengiriman data yang tidak valid
        }

        $.ajax({
            type: 'POST',
            url: '/guru/setujui-bimbingan/' + bimbinganId,
            data: {
                _token: '{{ csrf_token() }}',
                respon: alasanPersetujuan
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
        $("#setujuiModal").modal('hide');
    }
</script>


<script>
    document.querySelectorAll(".open-modal2").forEach(function(button) {
        button.addEventListener("click", function() {
            var bimbinganId = this.getAttribute("data-bimbinganid2");
            var modal = new bootstrap.Modal(document.getElementById("tolakModal"));
            modal.show();

            // Simpan ID bimbingan ini dalam elemen dengan ID "idBimbingan"
            document.getElementById("idBimbingan2").dataset.bimbinganid = bimbinganId;
        });
    });
</script>

<!-- Modal Tolak -->
<div class="modal fade" id="tolakModal" tabindex="-1" role="dialog" aria-labelledby="tolakModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tolakModalLabel">Penolakan Bimbingan</h5>
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
                        <div id="siswaNama">{{ $bim->magang->siswa->nisn }} - {{ $bim->magang->siswa->nama }}</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="siswaNama">komentar</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div id="siswaNama">{{ $bim->komentar }}</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="siswaNama">Tgl Bimbingan</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div id="siswaNama">{{ date('d-m-Y', strtotime($bim->created_at)) }} </div>
                    </div>
                </div>
                <form id="setujuiForm">
                    <!-- Formulir persetujuan -->
                    <textarea class="form-control" id="respon2" name="respon" placeholder="Alasan Ditolak"></textarea>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-success" onclick="tolakBimbingan()">Ditolak</button>
            </div>
        </div>
    </div>
</div>

<script>
    function tolakBimbingan() {
        var bimbinganId = $("#idBimbingan2").data("bimbinganid");
        var alasanDitolak = $('#respon2').val();

        if (!alasanDitolak) {
            // Handle jika pengguna belum memilih guru atau jika tidak ada ID magang
            alert('Silahkan isi alasan terlebih dahulu');
            return; // Keluar dari fungsi untuk mencegah pengiriman data yang tidak valid
        }

        $.ajax({
            type: 'POST',
            url: '/guru/tolak-bimbingan/' + bimbinganId,
            data: {
                _token: '{{ csrf_token() }}',
                respon: alasanDitolak
            },
            success: function(data) {
                // Handle jika simpan berhasil
                // Tampilkan notifikasi
                alert('Berhasil ditolak ');

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
        $("#tolakModal").modal('hide');
    }
</script>

@endsection