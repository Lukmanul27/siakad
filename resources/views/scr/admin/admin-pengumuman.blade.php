@extends('layouts.appadmin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        @include('layouts.sidebar.admin-appsidebar')

        <!-- Main Content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Pengumuman</h1>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahPengumumanModal">
                    <i class="fas fa-plus"></i> Buat Pengumuman
                </button>
            </div>

            <!-- Daftar Pengumuman -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Pengumuman</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Judul</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="pengumumanTableBody">
                                <!-- Data akan diisi oleh JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Modal Tambah Pengumuman -->
<div class="modal fade" id="tambahPengumumanModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Buat Pengumuman Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formTambahPengumuman" onsubmit="handleSubmit(event)">
                    <div class="mb-3">
                        <label class="form-label">Judul Pengumuman</label>
                        <input type="text" class="form-control" name="judul" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Isi Pengumuman</label>
                        <textarea class="form-control" name="isi" rows="5" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Lampiran (opsional)</label>
                        <input type="file" class="form-control" name="lampiran">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" form="formTambahPengumuman" class="btn btn-primary">Publikasikan</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Data sementara untuk daftar pengumuman
    let pengumumanData = [
        {
            id: 1,
            judul: 'Jadwal Ujian Semester Ganjil',
            tanggal: '2023-12-01',
            status: 'aktif'
        },
        {
            id: 2,
            judul: 'Rapat Guru dan Staff',
            tanggal: '2023-12-05',
            status: 'aktif'
        }
    ];

    // Fungsi untuk menampilkan data pengumuman
    function renderPengumumanTable() {
        const tbody = $('#pengumumanTableBody');
        tbody.empty();

        pengumumanData.forEach((pengumuman, index) => {
            tbody.append(`
                <tr>
                    <td>${index + 1}</td>
                    <td>${pengumuman.judul}</td>
                    <td>${pengumuman.tanggal}</td>
                    <td>
                        <span class="badge bg-${pengumuman.status === 'aktif' ? 'success' : 'secondary'}">
                            ${pengumuman.status}
                        </span>
                    </td>
                    <td>
                        <button class="btn btn-sm btn-info" onclick="viewPengumuman(${pengumuman.id})">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="btn btn-sm btn-warning" onclick="editPengumuman(${pengumuman.id})">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger" onclick="deletePengumuman(${pengumuman.id})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `);
        });
    }

    // Inisialisasi DataTable
    $('#dataTable').DataTable();
    
    // Render tabel pengumuman
    renderPengumumanTable();
});

// Fungsi-fungsi handler
function handleSubmit(event) {
    event.preventDefault();
    // Implementasi tambah pengumuman
}

function viewPengumuman(id) {
    // Implementasi lihat detail pengumuman
}

function editPengumuman(id) {
    // Implementasi edit pengumuman
}

function deletePengumuman(id) {
    // Implementasi hapus pengumuman
}
</script>
@endsection
