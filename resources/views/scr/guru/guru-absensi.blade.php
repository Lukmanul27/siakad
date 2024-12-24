@extends('layouts.appguru')

@section('title', 'Absensi Siswa')
@section('content')
<div class="container-fluid">
    <div class="row">
        @include('layouts.sidebar.guru-appsidebar')
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Absensi Siswa</h1>
            </div>

            <!-- Button untuk memicu modal -->
            <button type="button" class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#formAbsensiModal">
                <i class="fas fa-plus me-2"></i>Daftar Absensi Siswa
            </button>

            <!-- Modal Form Pemilihan Kelas -->
            <div class="modal fade" id="formAbsensiModal" tabindex="-1" aria-labelledby="formAbsensiModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="formAbsensiModalLabel">Pilih Kelas dan Mata Pelajaran</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="formAbsensi" action="{{ url('/guru/fungsionals/kehadiran-siswa') }}" method="GET">
                                <div class="mb-3">
                                    <label for="matapelajaran" class="form-label">Mata Pelajaran</label>
                                    <select class="form-select" id="matapelajaran" name="matapelajaran" required>
                                        <option value="">Pilih Mata Pelajaran...</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="kelas" class="form-label">Kelas</label>
                                    <select class="form-select" id="kelas" name="kelas" required>
                                        <option value="">Pilih Kelas...</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="tanggal" class="form-label">Tanggal</label>
                                    <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    <button type="submit" class="btn btn-primary">Tampilkan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Rekap Kehadiran -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Rekap Kehadiran</h6>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="filterTanggal" class="form-label">Tanggal</label>
                            <input type="date" class="form-control" id="filterTanggal">
                        </div>
                        <div class="col-md-4">
                            <label for="filterKelas" class="form-label">Kelas</label>
                            <select class="form-select" id="filterKelas">
                                <option value="">Semua Kelas</option>
                            </select>
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button class="btn btn-primary me-2" onclick="filterData()">Filter</button>
                            <button class="btn btn-secondary" onclick="showAllData()">Tampilkan Semua</button>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Kelas</th>
                                    <th>Tanggal</th>
                                    <th>Hadir</th>
                                    <th>Sakit</th>
                                    <th>Izin</th>
                                    <th>Alpha</th>
                                    <th>Total Siswa</th>
                                </tr>
                            </thead>
                            <tbody id="absensiTableBody">
                                <!-- Data akan diisi oleh JavaScript -->
                            </tbody>
                            <tfoot>
                                <tr class="table-secondary">
                                    <td colspan="2"><strong>Total</strong></td>
                                    <td id="totalHadir"><strong>0</strong></td>
                                    <td id="totalSakit"><strong>0</strong></td>
                                    <td id="totalIzin"><strong>0</strong></td>
                                    <td id="totalAlpha"><strong>0</strong></td>
                                    <td id="totalSiswa"><strong>0</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
// Data sementara untuk kelas dan mata pelajaran
const dummyKelas = [
    {id: 'X-IPA1', nama: 'X IPA 1'},
    {id: 'X-IPA2', nama: 'X IPA 2'}, 
    {id: 'XI-IPA1', nama: 'XI IPA 1'}
];

const dummyMapel = [
    {id: 'MTK', nama: 'Matematika'},
    {id: 'BIO', nama: 'Biologi'},
    {id: 'FIS', nama: 'Fisika'},
    {id: 'KIM', nama: 'Kimia'}
];

// Data sementara untuk absensi
const dummyData = [
    {kelas: 'X-IPA1', tanggal: '2024-01-15', hadir: 28, sakit: 2, izin: 1, alpha: 1, total: 32},
    {kelas: 'X-IPA1', tanggal: '2024-01-16', hadir: 30, sakit: 1, izin: 1, alpha: 0, total: 32}, 
    {kelas: 'X-IPA2', tanggal: '2024-01-15', hadir: 29, sakit: 2, izin: 1, alpha: 0, total: 32},
    {kelas: 'XI-IPA1', tanggal: '2024-01-15', hadir: 27, sakit: 3, izin: 1, alpha: 1, total: 32}
];

// Fungsi untuk mengisi dropdown kelas dan mapel
function populateDropdowns() {
    const kelasDropdown = document.getElementById('kelas');
    const mapelDropdown = document.getElementById('matapelajaran');
    const filterKelasDropdown = document.getElementById('filterKelas');
    
    // Mengisi dropdown kelas
    dummyKelas.forEach(kelas => {
        kelasDropdown.innerHTML += `<option value="${kelas.id}">${kelas.nama}</option>`;
        filterKelasDropdown.innerHTML += `<option value="${kelas.id}">${kelas.nama}</option>`;
    });
    
    // Mengisi dropdown mata pelajaran
    dummyMapel.forEach(mapel => {
        mapelDropdown.innerHTML += `<option value="${mapel.id}">${mapel.nama}</option>`;
    });
}

// Fungsi untuk memfilter data
function filterData() {
    const tanggal = document.getElementById('filterTanggal').value;
    const kelas = document.getElementById('filterKelas').value;
    
    let filteredData = [...dummyData];
    
    if (tanggal) {
        filteredData = filteredData.filter(item => item.tanggal === tanggal);
    }
    
    if (kelas) {
        filteredData = filteredData.filter(item => item.kelas === kelas);
    }
    
    updateTable(filteredData);
}

// Fungsi untuk menampilkan semua data
function showAllData() {
    document.getElementById('filterTanggal').value = '';
    document.getElementById('filterKelas').value = '';
    updateTable(dummyData);
}

// Fungsi untuk mengupdate tabel
function updateTable(data) {
    const tbody = document.getElementById('absensiTableBody');
    tbody.innerHTML = '';
    
    let totalHadir = 0, totalSakit = 0, totalIzin = 0, totalAlpha = 0, totalSiswa = 0;
    
    data.forEach(item => {
        const kelas = dummyKelas.find(k => k.id === item.kelas);
        tbody.innerHTML += `
            <tr>
                <td>${kelas ? kelas.nama : item.kelas}</td>
                <td>${item.tanggal}</td>
                <td>${item.hadir}</td>
                <td>${item.sakit}</td>
                <td>${item.izin}</td>
                <td>${item.alpha}</td>
                <td>${item.total}</td>
            </tr>
        `;
        
        totalHadir += item.hadir;
        totalSakit += item.sakit;
        totalIzin += item.izin;
        totalAlpha += item.alpha;
        totalSiswa += item.total;
    });
    
    // Update total
    document.getElementById('totalHadir').innerHTML = `<strong>${totalHadir}</strong>`;
    document.getElementById('totalSakit').innerHTML = `<strong>${totalSakit}</strong>`;
    document.getElementById('totalIzin').innerHTML = `<strong>${totalIzin}</strong>`;
    document.getElementById('totalAlpha').innerHTML = `<strong>${totalAlpha}</strong>`;
    document.getElementById('totalSiswa').innerHTML = `<strong>${totalSiswa}</strong>`;
}

// Memuat data awal
document.addEventListener('DOMContentLoaded', function() {
    populateDropdowns();
    showAllData();
});
</script>
@endsection
