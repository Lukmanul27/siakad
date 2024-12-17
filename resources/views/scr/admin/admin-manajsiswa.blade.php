@extends('layouts.appadmin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        @include('layouts.sidebar.admin-appsidebar')

        <!-- Main Content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Manajemen Siswa</h1>
                <div>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahSiswaModal">
                        <i class="fas fa-plus"></i> Tambah Siswa
                    </button>
                </div>
            </div>

            <!-- Filter Kelas -->
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-3">
                            <select class="form-select" id="filterKelas">
                                <option value="">Semua Kelas</option>
                                <option value="X IPA 1">X IPA 1</option>
                                <option value="X IPA 2">X IPA 2</option>
                                <option value="X IPS 1">X IPS 1</option>
                                <option value="X IPS 2">X IPS 2</option>
                                <!-- Tambahkan opsi kelas lainnya -->
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabel Daftar Siswa -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Siswa</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NIS</th>
                                    <th>Nama</th>
                                    <th>Kelas</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Alamat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="siswaTableBody">
                                <!-- Data akan diisi oleh JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Modal Tambah Siswa -->
<div class="modal fade" id="tambahSiswaModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Siswa Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formTambahSiswa" onsubmit="handleSubmitSiswa(event)">
                    <div class="mb-3">
                        <label class="form-label">NIS</label>
                        <input type="text" class="form-control" name="nis" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kelas</label>
                        <select class="form-select" name="kelas" required>
                            <option value="">Pilih Kelas</option>
                            <option value="X IPA 1">X IPA 1</option>
                            <option value="X IPA 2">X IPA 2</option>
                            <option value="X IPS 1">X IPS 1</option>
                            <option value="X IPS 2">X IPS 2</option>
                            <!-- Tambahkan opsi kelas lainnya -->
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis Kelamin</label>
                        <select class="form-select" name="jenis_kelamin" required>
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea class="form-control" name="alamat" rows="3" required></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" form="formTambahSiswa" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Data sementara untuk daftar siswa
    let siswaData = [
        {
            id: 1,
            nis: '2021001',
            nama: 'Ahmad Rizki',
            kelas: 'X IPA 1',
            jenis_kelamin: 'L',
            alamat: 'Jl. Merdeka No. 123'
        },
        {
            id: 2,
            nis: '2021002', 
            nama: 'Siti Nurhaliza',
            kelas: 'X IPA 1',
            jenis_kelamin: 'P',
            alamat: 'Jl. Pahlawan No. 45'
        }
    ];

    // Fungsi untuk menampilkan data siswa
    function renderSiswaTable() {
        const tbody = $('#siswaTableBody');
        tbody.empty();

        siswaData.forEach((siswa, index) => {
            tbody.append(`
                <tr>
                    <td>${index + 1}</td>
                    <td>${siswa.nis}</td>
                    <td>${siswa.nama}</td>
                    <td>${siswa.kelas}</td>
                    <td>${siswa.jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan'}</td>
                    <td>${siswa.alamat}</td>
                    <td>
                        <button class="btn btn-sm btn-warning" onclick="editSiswa(${siswa.id})">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger" onclick="deleteSiswa(${siswa.id})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `);
        });
    }

    // Inisialisasi DataTable
    $('#dataTable').DataTable();
    
    // Render tabel
    renderSiswaTable();

    // Filter berdasarkan kelas
    $('#filterKelas').change(function() {
        const selectedKelas = $(this).val();
        // Implementasi filter
    });
});

// Fungsi-fungsi handler form
function handleSubmitSiswa(event) {
    event.preventDefault();
    // Implementasi tambah siswa
}

function editSiswa(id) {
    // Implementasi edit siswa
}

function deleteSiswa(id) {
    // Implementasi hapus siswa
}
</script>
@endsection
