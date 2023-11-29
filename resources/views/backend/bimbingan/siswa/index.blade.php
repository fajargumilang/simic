@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{ __('Progress Bimbingan Magang') }}
                    @if ($magang->status == 1)
                    @if (!$existingSidang)
                    <a href="{{route('siswa.bimbingan.add')}}" class="float-right btn btn-sm btn-primary">Bimbingan</a>
                    @else
                    <a class=" float-right btn btn-sm btn-secondary mb-2" style="cursor:not-allowed" disabled>
                        <span style="color:white">Bimbingan</span>
                    </a>
                    @endif
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
                    <div class="row">
                        <!-- Bagian Profil Siswa (Kiri Atas) -->
                        <div class="col-md-6">
                            <div class=" profile-info">
                                <div class="row">
                                    <div class="profile-label"><b>Nama Siswa:</b>
                                        {{Auth::user()->siswa->nisn }} - {{Auth::user()->siswa->nama }}
                                    </div>
                                    <div class="profile-label"><b>Jurusan:</b>
                                        {{Auth::user()->siswa->jurusan->jurusan }}
                                    </div>
                                    <div class="profile-label"><b>Tahun Ajaran:</b>
                                        {{ Auth::user()->siswa->tahun_awal}}/{{Auth::user()->siswa->tahun_akhir }}
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
                            @if($progressPercentage == 100)
                            @if (!$existingSidang)
                            <form action="{{route('siswa.ajukan-sidang')}}" method="post" class="d-inline" onsubmit="return confirm('Apakah anda yakin ingin mengajukan sidang ?')">
                                @csrf
                                <button class="btn btn-success btn-sm">
                                    Ajukan Sidang
                                </button>
                            </form>
                            @else
                            <a class="btn btn-sm btn-secondary mb-2" style="cursor:not-allowed" disabled>
                                <span style="color:white">Anda sudah mengajukan sidang</span>
                            </a>
                            @endif
                            @endif
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
                                <tr>
                                    @if ($magang->status !== 1)
                                    <td colspan="5" href="{{route('permohonan-magang.index')}}" class="text-center">Mohon Hubungi Staff TU untuk Permohonan Magang untuk ACC Permohonan Magang</td>
                                    @else
                                    @foreach ($bimbingan as $b)
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('siswa.file-preview', ['id' => $b->id]) }}" target="_blank">Tampilkan File</a>
                                    </td>
                                    <td class="text-center">{{ $b->komentar }}</td>
                                    <td class="text-center">{{ !empty($b->created_at) ? date('d-m-Y', strtotime($b->created_at)) : '-' }}</td>
                                    @if ($b->status == 2)
                                    <td class="text-center" style="color:orange">Menunggu Persetujuan Pembimbing</td>
                                    @elseif ($b->status == 1)
                                    <td class="text-center" style="color:green">Disetujui Pembimbing</td>
                                    @else
                                    <td class="text-center" style="color:red">Ditolak Pembimbing</td>
                                    @endif
                                    <td class="text-center">{{!empty ($b->respon) ? $b->respon : '-'}}</td>

                                    <td class="text-center">
                                        @if ($b->respon == null)
                                        <form action="{{ route('siswa.bimbingan.destroy', ['id' => $b->id]) }}" method="post" class="d-inline" onsubmit="return confirm('Yakin hapus data bimbingan?')">
                                            @method('delete')
                                            @csrf
                                            <button class="btn btn-danger btn-sm">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                        @else
                                        <a class="btn btn-sm btn-secondary" style="cursor:not-allowed" disabled>
                                            <i class="fa fa-trash"></i>
                                        </a>
                                        </button>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection