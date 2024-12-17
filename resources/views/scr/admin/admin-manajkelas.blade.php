@extends('layouts.appadmin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        @include('layouts.sidebar.admin-appsidebar')

        <!-- Main Content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Manajemen Kelas</h1>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahKelasModal">
                    <i class="fas fa-plus"></i> Tambah Kelas
                </button>
            </div>

            <!-- Tabel Daftar Kelas -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Kelas</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Kelas</th>
                                    <th>Jurusan</th>
                                    <th>Wali Kelas</th>
                                    <th>Jumlah Siswa</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="kelasTableBody">
                                <!-- Data akan diisi oleh JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Modal Tambah Kelas -->
<div class="modal fade" id="tambahKelasModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Kelas Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formTambahKelas" onsubmit="handleSubmit(event)">
                    <div class="mb-3">
                        <label class="form-label">Tingkat Kelas</label>
                        <select class="form-select" name="tingkat" required>
                            <option value="">Pilih Tingkat</option>
                            <option value="X">X (Sepuluh)</option>
                            <option value="XI">XI (Sebelas)</option>
                            <option value="XII">XII (Dua Belas)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jurusan</label>
                        <select class="form-select" name="jurusan" required>
                            <option value="">Pilih Jurusan</option>
                            <option value="IPA">IPA</option>
                            <option value="IPS">IPS</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Wali Kelas</label>
                        <select class="form-select" name="wali_kelas" required>
                            <option value="">Pilih Wali Kelas</option>
                            <!-- Opsi guru akan diisi oleh JavaScript -->
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" form="formTambahKelas" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Kelas -->
<div class="modal fade" id="editKelasModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Kelas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formEditKelas" onsubmit="handleEdit(event)">
                    <input type="hidden" name="id" id="editId">
                    <div class="mb-3">
                        <label class="form-label">Tingkat Kelas</label>
                        <select class="form-select" name="tingkat" required>
                            <option value="">Pilih Tingkat</option>
                            <option value="X">X (Sepuluh)</option>
                            <option value="XI">XI (Sebelas)</option>
                            <option value="XII">XII (Dua Belas)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jurusan</label>
                        <select class="form-select" name="jurusan" required>
                            <option value="">Pilih Jurusan</option>
                            <option value="IPA">IPA</option>
                            <option value="IPS">IPS</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Wali Kelas</label>
                        <select class="form-select" name="wali_kelas" required>
                            <option value="">Pilih Wali Kelas</option>
                            <!-- Opsi guru akan diisi oleh JavaScript -->
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" form="formEditKelas" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Data sementara untuk daftar kelas
    let kelasData = [
        {
            id: 1,
            nama: 'X IPA 1',
            jurusan: 'IPA',
            waliKelas: 'Budi Santoso',
            jumlahSiswa: 32
        },
        {
            id: 2,
            nama: 'X IPA 2', 
            jurusan: 'IPA',
            waliKelas: 'Siti Aminah',
            jumlahSiswa: 30
        },
        {
            id: 3,
            nama: 'X IPS 1',
            jurusan: 'IPS',
            waliKelas: 'Ahmad Hidayat',
            jumlahSiswa: 34
        }
    ];

    // Fungsi untuk menampilkan data kelas
    function renderKelasTable() {
        const tbody = $('#kelasTableBody');
        tbody.empty();

        kelasData.forEach((kelas, index) => {
            tbody.append(`
                <tr>
                    <td>${index + 1}</td>
                    <td>${kelas.nama}</td>
                    <td>${kelas.jurusan}</td>
                    <td>${kelas.waliKelas}</td>
                    <td>${kelas.jumlahSiswa}</td>
                    <td>
                        <button class="btn btn-sm btn-warning" onclick="editKelas(${kelas.id})">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger" onclick="deleteKelas(${kelas.id})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `);
        });
    }

    // Inisialisasi DataTable
    $('#dataTable').DataTable();
    
    // Render tabel kelas
    renderKelasTable();
});

// Fungsi-fungsi handler form
function handleSubmit(event) {
    event.preventDefault();
    const formData = new FormData(event.target);
    const tingkat = formData.get('tingkat');
    const jurusan = formData.get('jurusan');
    const waliKelas = formData.get('wali_kelas');

    // Hitung nomor kelas berikutnya berdasarkan tingkat dan jurusan yang dipilih
    const existingClasses = kelasData.filter(k => 
        k.nama.startsWith(tingkat) && 
        k.nama.includes(jurusan)
    );
    const nextNumber = existingClasses.length + 1;

    // Buat nama kelas otomatis
    const namaKelas = `${tingkat} ${jurusan} ${nextNumber}`;

    // Implementasi tambah kelas dengan nomor otomatis
    // ... kode untuk menyimpan kelas baru
}

function editKelas(id) {
    // Implementasi edit kelas
}

function deleteKelas(id) {
    // Implementasi hapus kelas
}
</script>
@endsection
