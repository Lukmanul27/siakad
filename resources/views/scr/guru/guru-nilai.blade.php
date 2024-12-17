@extends('layouts.appguru')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('layouts.sidebar.guru-appsidebar')
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Input Nilai Siswa</h1>
            </div>

            <!-- Button untuk memicu modal -->
            <button type="button" class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#formNilaiModal">
                <i class="fas fa-plus me-2"></i>Input Nilai Siswa
            </button>

            <!-- Modal Form Pemilihan Kelas -->
            <div class="modal fade" id="formNilaiModal" tabindex="-1" aria-labelledby="formNilaiModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="formNilaiModalLabel">Pilih Kelas dan Mata Pelajaran</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="formNilai" action="{{ url('/guru/fungsionals/nilai-siswa') }}" method="GET">
                                <div class="mb-3">
                                    <label for="matapelajaran" class="form-label">Mata Pelajaran</label>
                                    <select class="form-select" id="matapelajaran" name="matapelajaran" required>
                                        <option value="">Pilih Mata Pelajaran...</option>
                                        <option value="MTK">Matematika</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="kelas" class="form-label">Kelas</label>
                                    <select class="form-select" id="kelas" name="kelas" required>
                                        <option value="">Pilih Kelas...</option>
                                        <option value="X-IPA1">X IPA 1</option>
                                        <option value="X-IPA2">X IPA 2</option>
                                        <option value="XI-IPA1">XI IPA 1</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="jenis_nilai" class="form-label">Jenis Nilai</label>
                                    <select class="form-select" id="jenis_nilai" name="jenis_nilai" required>
                                        <option value="">Pilih Jenis Nilai...</option>
                                        <option value="tugas">Tugas</option>
                                        <option value="kuis">Kuis</option>
                                        <option value="uts">UTS</option>
                                        <option value="uas">UAS</option>
                                    </select>
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

            <!-- Tabel Rekap Nilai -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Rekap Nilai</h6>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="filterKelas" class="form-label">Kelas</label>
                            <select class="form-select" id="filterKelas">
                                <option value="">Semua Kelas</option>
                                <option value="X IPA 1">X IPA 1</option>
                                <option value="X IPA 2">X IPA 2</option>
                                <option value="XI IPA 1">XI IPA 1</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="filterJenisNilai" class="form-label">Jenis Nilai</label>
                            <select class="form-select" id="filterJenisNilai">
                                <option value="">Semua Jenis</option>
                                <option value="tugas">Tugas</option>
                                <option value="kuis">Kuis</option>
                                <option value="uts">UTS</option>
                                <option value="uas">UAS</option>
                            </select>
                        </div>
                        <div class="col-md-6 d-flex align-items-end">
                            <button class="btn btn-primary me-2" onclick="filterNilai()">Filter</button>
                            <button class="btn btn-secondary" onclick="showAllNilai()">Tampilkan Semua</button>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>NIS</th>
                                    <th>Nama Siswa</th>
                                    <th>Kelas</th>
                                    <th>Tugas</th>
                                    <th>Kuis</th>
                                    <th>UTS</th>
                                    <th>UAS</th>
                                    <th>Nilai Akhir</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="nilaiTableBody">
                                <!-- Data akan diisi oleh JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
// Data dummy untuk nilai siswa
const nilaiData = [
    {
        nis: '1001',
        nama: 'Ahmad Rizki',
        kelas: 'X IPA 1',
        tugas: 85,
        kuis: 80,
        uts: 78,
        uas: 82
    },
    {
        nis: '1002',
        nama: 'Budi Santoso',
        kelas: 'X IPA 1',
        tugas: 90,
        kuis: 85,
        uts: 88,
        uas: 86
    }
];

// Function untuk menghitung nilai akhir
function hitungNilaiAkhir(nilai) {
    return ((nilai.tugas * 0.2) + (nilai.kuis * 0.2) + (nilai.uts * 0.3) + (nilai.uas * 0.3)).toFixed(2);
}

// Function untuk memfilter data nilai
function filterNilai() {
    const kelas = document.getElementById('filterKelas').value;
    let filteredData = [...nilaiData];
    
    if (kelas) {
        filteredData = filteredData.filter(item => item.kelas === kelas);
    }
    
    updateNilaiTable(filteredData);
}

// Function untuk menampilkan semua data nilai
function showAllNilai() {
    document.getElementById('filterKelas').value = '';
    document.getElementById('filterJenisNilai').value = '';
    updateNilaiTable(nilaiData);
}

// Function untuk mengupdate tabel nilai
function updateNilaiTable(data) {
    const tbody = document.getElementById('nilaiTableBody');
    tbody.innerHTML = '';
    
    data.forEach(item => {
        const nilaiAkhir = hitungNilaiAkhir(item);
        tbody.innerHTML += `
            <tr>
                <td>${item.nis}</td>
                <td>${item.nama}</td>
                <td>${item.kelas}</td>
                <td>${item.tugas}</td>
                <td>${item.kuis}</td>
                <td>${item.uts}</td>
                <td>${item.uas}</td>
                <td>${nilaiAkhir}</td>
                <td>
                    <button class="btn btn-sm btn-warning me-1" onclick="editNilai('${item.nis}')">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-sm btn-danger" onclick="deleteNilai('${item.nis}')">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
        `;
    });
}

// Function untuk mengedit nilai
function editNilai(nis) {
    // Implementasi edit nilai
    console.log('Edit nilai untuk NIS:', nis);
}

// Function untuk menghapus nilai
function deleteNilai(nis) {
    // Implementasi delete nilai
    console.log('Hapus nilai untuk NIS:', nis);
}

// Load data awal
document.addEventListener('DOMContentLoaded', function() {
    showAllNilai();
});
</script>
@endsection
