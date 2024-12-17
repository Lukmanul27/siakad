@extends('layouts.appguru')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        @include('layouts.sidebar.guru-appsidebar')

        <!-- Main Content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Dashboard Guru</h1>
            </div>

            <!-- Quick Stats -->
            <div class="row" id="quickStats">
                <!-- Stats akan diisi oleh JavaScript -->
            </div>

            <!-- Jadwal Hari Ini -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Jadwal Mengajar Hari Ini</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Jam</th>
                                            <th>Kelas</th>
                                            <th>Mata Pelajaran</th>
                                            <th>Ruangan</th>
                                        </tr>
                                    </thead>
                                    <tbody id="jadwalHariIni">
                                        <!-- Jadwal akan diisi oleh JavaScript -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pengumuman Terbaru -->
            <div class="row">
                <div class="col-12">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">Pengumuman Terbaru</h6>
                            <a href="{{ url('/guru/pengumuman') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
                        </div>
                        <div class="card-body">
                            <div class="list-group" id="pengumumanTerbaru">
                                <!-- Pengumuman akan diisi oleh JavaScript -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
// Data sementara untuk quick stats
const statsData = [
    {
        title: 'Total Kelas',
        value: '6',
        icon: 'fas fa-chalkboard-teacher',
        color: 'primary'
    },
    {
        title: 'Total Siswa',
        value: '180',
        icon: 'fas fa-users',
        color: 'success'
    },
    {
        title: 'Jadwal Hari Ini',
        value: '4 Kelas',
        icon: 'fas fa-calendar',
        color: 'info'
    }
];

// Data sementara untuk jadwal
const jadwalData = [
    {
        jam: '07:00 - 08:30',
        kelas: 'X IPA 1',
        mataPelajaran: 'Matematika',
        ruangan: 'R.101'
    },
    {
        jam: '08:30 - 10:00',
        kelas: 'X IPA 2',
        mataPelajaran: 'Matematika',
        ruangan: 'R.102'
    },
    {
        jam: '10:15 - 11:45',
        kelas: 'XI IPA 1',
        mataPelajaran: 'Matematika',
        ruangan: 'R.201'
    }
];

// Data sementara untuk pengumuman
const pengumumanData = [
    {
        judul: 'Rapat Guru',
        waktu: '3 hari yang lalu',
        isi: 'Rapat koordinasi guru akan dilaksanakan pada hari Jumat.'
    },
    {
        judul: 'Pengumpulan Nilai UTS',
        waktu: '5 hari yang lalu',
        isi: 'Batas waktu pengumpulan nilai UTS adalah minggu depan.'
    }
];

// Render quick stats
function renderQuickStats() {
    const statsContainer = document.getElementById('quickStats');
    statsData.forEach(stat => {
        statsContainer.innerHTML += `
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-${stat.color} shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-${stat.color} text-uppercase mb-1">
                                    ${stat.title}</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">${stat.value}</div>
                            </div>
                            <div class="col-auto">
                                <i class="${stat.icon} fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
    });
}

// Render jadwal
function renderJadwal() {
    const jadwalContainer = document.getElementById('jadwalHariIni');
    jadwalData.forEach(jadwal => {
        jadwalContainer.innerHTML += `
            <tr>
                <td>${jadwal.jam}</td>
                <td>${jadwal.kelas}</td>
                <td>${jadwal.mataPelajaran}</td>
                <td>${jadwal.ruangan}</td>
            </tr>
        `;
    });
}

// Render pengumuman
function renderPengumuman() {
    const pengumumanContainer = document.getElementById('pengumumanTerbaru');
    pengumumanData.forEach(pengumuman => {
        pengumumanContainer.innerHTML += `
            <a href="{{ url('/guru/pengumuman') }}" class="list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-between">
                    <h6 class="mb-1">${pengumuman.judul}</h6>
                    <small>${pengumuman.waktu}</small>
                </div>
                <p class="mb-1">${pengumuman.isi}</p>
            </a>
        `;
    });
}

// Load semua data saat halaman dimuat
document.addEventListener('DOMContentLoaded', function() {
    renderQuickStats();
    renderJadwal();
    renderPengumuman();
});
</script>
@endsection
