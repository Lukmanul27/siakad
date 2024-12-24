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
                                </tr>
                            </thead>
                            <tbody id="jadwalTableBody">
                                <!-- Data akan diisi oleh JavaScript -->
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

<script>
// Data sementara untuk jadwal mengajar
const jadwalData = [
    {
        hari: 'Senin',
        jam: '07:00 - 08:30',
        mataPelajaran: 'Matematika',
        kelas: 'X IPA 1',
        ruangan: 'R.101'
    },
    {
        hari: 'Senin',
        jam: '08:30 - 10:00',
        mataPelajaran: 'Matematika',
        kelas: 'X IPA 2',
        ruangan: 'R.102'
    },
    {
        hari: 'Selasa',
        jam: '07:00 - 08:30',
        mataPelajaran: 'Matematika',
        kelas: 'XI IPA 1',
        ruangan: 'R.201'
    },
    {
        hari: 'Rabu',
        jam: '10:15 - 11:45',
        mataPelajaran: 'Matematika',
        kelas: 'X IPA 3',
        ruangan: 'R.103'
    },
    {
        hari: 'Kamis',
        jam: '13:00 - 14:30',
        mataPelajaran: 'Matematika',
        kelas: 'XI IPA 2',
        ruangan: 'R.202'
    }
];

// Fungsi untuk menampilkan data jadwal
function renderJadwal() {
    const jadwalTableBody = document.getElementById('jadwalTableBody');
    jadwalTableBody.innerHTML = '';

    jadwalData.forEach(jadwal => {
        jadwalTableBody.innerHTML += `
            <tr>
                <td>${jadwal.hari}</td>
                <td>${jadwal.jam}</td>
                <td>${jadwal.mataPelajaran}</td>
                <td>${jadwal.kelas}</td>
                <td>${jadwal.ruangan}</td>
            </tr>
        `;
    });
}

// Load data saat halaman dimuat
document.addEventListener('DOMContentLoaded', function() {
    renderJadwal();
});
</script>
@endsection
