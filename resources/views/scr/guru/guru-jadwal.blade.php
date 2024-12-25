@extends('layouts.appguru')

@section('title', 'Jadwal Mengajar')
@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        @include('layouts.sidebar.guru-appsidebar')

        <!-- Main Content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Jadwal Mengajar</h1>
            </div>

            <!-- Jadwal Table -->
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="bg-light">
                                <tr>
                                    <th>Hari</th>
                                    <th>Jam</th>
                                    <th>Mata Pelajaran</th>
                                    <th>Kelas</th>
                                    <th>Ruangan</th>
                                    <th>Jam Ke</th>
                                    <th>Waktu</th>
                                </tr>
                            </thead>
                            <tbody id="jadwalTableBody">
                                @foreach ($jadwals as $jadwal)
                                    <tr>
                                        <td>{{ $jadwal->hari }}</td>
                                        <td>{{ $jadwal->waktu }}</td>
                                        <td>{{ $jadwal->mataPelajaran->nama }}</td>
                                        <td>{{ $jadwal->kelas->nama_kelas }}</td>
                                        <td>{{ $jadwal->ruangan }}</td>
                                        <td>{{ $jadwal->jam_ke }}</td>
                                        <td>{{ $jadwal->waktu }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Keterangan -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Keterangan</h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li><i class="fas fa-info-circle text-info me-2"></i> Jadwal dapat berubah sewaktu-waktu</li>
                        <li><i class="fas fa-clock text-warning me-2"></i> Harap hadir 10 menit sebelum jam pelajaran dimulai</li>
                        <li><i class="fas fa-exclamation-triangle text-danger me-2"></i> Jika berhalangan hadir, harap memberikan informasi sebelumnya</li>
                    </ul>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
