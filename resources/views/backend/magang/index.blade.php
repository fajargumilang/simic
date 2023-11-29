@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Data Magang') }}
                    <a href="{{ route('magang.list_approve') }}" class="float-right btn btn-sm btn-primary">Data Permohonan Magang</a>
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
                                    <th class="text-center">NISN</th>
                                    <th class="text-center">Siswa</th>
                                    <th class="text-center">Guru Pembimbing</th>
                                    <th class="text-center">Nama Perusahaan</th>
                                    <th class="text-center">Periode Magang</th>
                                    <th class="text-center">File Upload</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="7" class="text-center">TIDAK ADA DATA MAGANG SISWA</td>
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
                                    <th class="text-center">Periode Magang</th>
                                    <th class="text-center">File Upload</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1 @endphp
                                @foreach ($magang as $ma)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td class="text-capitalize">{{ $ma->siswa->nisn }}</td>
                                    <td class="text-capitalize">{{ $ma->siswa->nama }}</td>
                                    <td class="text-center">
                                        @if (!empty($ma->guru->nama))
                                        {{ $ma->guru->nama }}
                                        @else
                                        <button type="button" class="btn btn-primary open-modal" id="pilihSiswa" data-magang-id="{{ $ma->id }}" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Pilih Guru Pembimbing</button>
                                        @endif
                                    </td>

                                    <td>{{ $ma->namaperusahaan }}</td>
                                    <td>{{ !empty ($ma->awalmagang) ? date('d-m-Y', strtotime($ma->awalmagang)) : '-' }} / {{ !empty ($ma->akhirmagang) ? date('d-m-Y', strtotime($ma->akhirmagang)) : '-' }}</td>

                                    <td class="text-center">

                                        <a href="{{ route('admin.file-preview', ['id' => $ma->id]) }}" target="_blank">Tampilkan PDF</a>

                                    </td>

                                    <td class="text-center">
                                        <a href="{{ url('/datapegawai/edit/'.$ma->id) }}" class="btn btn-sm btn-success">
                                            <i class="fa fa-pencil-square-o"></i>
                                        </a>
                                        <!-- <form action="{{ route('guru.destroy', ['id' => $ma->id]) }}" method="post" class="d-inline" onsubmit="return confirm('Yakin hapus data magang ' + '{{ ucwords($ma->siswa->nama) }}' + ' ?')">

                                            @method('delete')
                                            @csrf
                                            <button class="btn btn-danger btn-sm">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form> -->
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
            var magangId = this.getAttribute("data-magang-id");
            var modal = new bootstrap.Modal(document.getElementById("staticBackdrop"));
            modal.show();

            // Simpan ID magang ini dalam elemen dropdown
            var pilihGuruDropdown = document.getElementById("pilihGuruDropdown");
            pilihGuruDropdown.dataset.magangId = magangId;
        });
    });
</script>

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            @if ($magang)
            <form action="{{ route('admin.pilih-pembimbing', ['id' => $ma->id]) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Pilih Guru Pembimbing</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="siswaNama">Nama Siswa</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <input type="text" id="" name="" class="form-control text-capitalize" value="{{ $ma->siswa->nama }}" placeholder="" readonly>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="pilihGuruDropdown"><b>Pilih Guru Pembimbing</b></label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <select class="form-control js-example-basic-single" id="pilihGuruDropdown" name="guru_id">
                                <option value="">- Pilih Guru Pembimbing</option>
                                @foreach ($guru as $g)
                                <option value="{{ $g->id }}">{{$g->nuptk}} - {{ $g->nama }}</option>
                                <!-- Tambahkan daftar guru di sini -->
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="namaPerusahaan">Nama Perusahaan</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <input type="text" id="" name="" class="form-control text-capitalize" value="{{ $ma->namaperusahaan }}" placeholder="" readonly>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="periodeMagang">Periode Magang</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <input type="text" id="" name="" class="form-control text-capitalize" value="{{ date('d-m-Y', strtotime($ma->awalmagang)) }} / {{ date('d-m-Y', strtotime($ma->akhirmagang)) }}" placeholder="" readonly>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="simpanGuruBtn" onclick="simpanGuru()">Simpan</button>
                </div>
            </form>
            @endif

        </div>
    </div>
</div>

<script>
    function simpanGuru() {
        var selectedGuru = document.getElementById("pilihGuruDropdown").value;
        var magangId = document.getElementById("pilihSiswa").dataset.magangId;

        if (!selectedGuru || !magangId) {
            // Handle jika pengguna belum memilih guru atau jika tidak ada ID magang
            alert('Silakan pilih seorang guru pembimbing terlebih dahulu.');
            return; // Keluar dari fungsi untuk mencegah pengiriman data yang tidak valid
        }

        // Kirim data ke server dengan AJAX
        $.ajax({
            type: 'POST',
            url: '/admin/magang/' + magangId,
            data: {
                _token: '{{ csrf_token() }}',
                guru_id: selectedGuru,
            },
            success: function(data) {
                // Handle jika simpan berhasil
                // Tampilkan notifikasi
                alert('Guru pembimbing berhasil dipilih ');


                // Refresh halaman
                location.reload();
            },
            error: function(error) {
                // Handle jika terjadi kesalahan saat menyimpan
                // Tampilkan notifikasi kesalahan
                alert('Terjadi kesalahan. Guru pembimbing tidak dapat dipilih.');
            }
        });


        // Tutup modal
        $("#staticBackdrop").modal('hide');
    }
</script>

<script>
    // In your Javascript (external .js resource or <script> tag)
    $(document).ready(function() {
        $('#pilihGuruDropdown').select2();
    });
</script>
@endsection