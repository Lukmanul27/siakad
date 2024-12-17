@extends('layouts.appadmin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        @include('layouts.sidebar.admin-appsidebar')

        <!-- Main Content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Manajemen Mata Pelajaran</h1>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahMapelModal">
                    <i class="fas fa-plus"></i> Tambah Mata Pelajaran
                </button>
            </div>

            <!-- Filter Jurusan -->
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-3">
                            <select class="form-select" id="filterJurusan">
                                <option value="">Semua Jurusan</option>
                                <option value="IPA">IPA</option>
                                <option value="IPS">IPS</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabel Daftar Mata Pelajaran -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Mata Pelajaran</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>Nama Mata Pelajaran</th>
                                    <th>Jurusan</th>
                                    <th>KKM</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="mapelTableBody">
                                <!-- Data akan diisi oleh JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Modal Tambah Mata Pelajaran -->
<div class="modal fade" id="tambahMapelModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Mata Pelajaran Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formTambahMapel" onsubmit="handleSubmit(event)">
                    <div class="mb-3">
                        <label class="form-label">Kode Mata Pelajaran</label>
                        <input type="text" class="form-control" name="kode" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Mata Pelajaran</label>
                        <input type="text" class="form-control" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jurusan</label>
                        <select class="form-select" name="jurusan" required>
                            <option value="">Pilih Jurusan</option>
                            <option value="IPA">IPA</option>
                            <option value="IPS">IPS</option>
                            <option value="UMUM">Umum</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">KKM</label>
                        <input type="number" class="form-control" name="kkm" min="0" max="100" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" form="formTambahMapel" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Data sementara untuk daftar mata pelajaran
    let mapelData = [
        {
            id: 1,
            kode: 'MTK01',
            nama: 'Matematika',
            jurusan: 'UMUM',
            kkm: 75
        },
        {
            id: 2,
            kode: 'FIS01',
            nama: 'Fisika',
            jurusan: 'IPA',
            kkm: 75
        },
        {
            id: 3,
            kode: 'EKO01',
            nama: 'Ekonomi',
            jurusan: 'IPS',
            kkm: 75
        }
    ];

    // Fungsi untuk menampilkan data mata pelajaran
    function renderMapelTable() {
        const tbody = $('#mapelTableBody');
        tbody.empty();

        mapelData.forEach((mapel, index) => {
            tbody.append(`
                <tr>
                    <td>${index + 1}</td>
                    <td>${mapel.kode}</td>
                    <td>${mapel.nama}</td>
                    <td>${mapel.jurusan}</td>
                    <td>${mapel.kkm}</td>
                    <td>
                        <button class="btn btn-sm btn-warning" onclick="editMapel(${mapel.id})">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger" onclick="deleteMapel(${mapel.id})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `);
        });
    }

    // Inisialisasi DataTable
    $('#dataTable').DataTable();
    
    // Render tabel mata pelajaran
    renderMapelTable();

    // Filter berdasarkan jurusan
    $('#filterJurusan').change(function() {
        const selectedJurusan = $(this).val();
        // Implementasi filter
    });
});

// Fungsi-fungsi handler form
function handleSubmit(event) {
    event.preventDefault();
    // Implementasi tambah mata pelajaran
}

function editMapel(id) {
    // Implementasi edit mata pelajaran
}

function deleteMapel(id) {
    // Implementasi hapus mata pelajaran
}
</script>
@endsection
