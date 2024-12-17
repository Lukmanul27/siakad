@extends('layouts.appadmin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        @include('layouts.sidebar.admin-appsidebar')

        <!-- Main Content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Manajemen Jadwal Pelajaran</h1>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahJadwalModal">
                    <i class="fas fa-plus"></i> Tambah Jadwal
                </button>
            </div>

            <!-- Filter Kelas -->
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-3">
                            <select class="form-select" id="filterKelas">
                                <option value="">Pilih Kelas</option>
                                <option value="X IPA 1">X IPA 1</option>
                                <option value="X IPA 2">X IPA 2</option>
                                <option value="X IPS 1">X IPS 1</option>
                                <option value="X IPS 2">X IPS 2</option>
                                <option value="XI IPA 1">XI IPA 1</option>
                                <option value="XI IPA 2">XI IPA 2</option>
                                <option value="XI IPS 1">XI IPS 1</option>
                                <option value="XI IPS 2">XI IPS 2</option>
                                <option value="XII IPA 1">XII IPA 1</option>
                                <option value="XII IPA 2">XII IPA 2</option>
                                <option value="XII IPS 1">XII IPS 1</option>
                                <option value="XII IPS 2">XII IPS 2</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabel Jadwal -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Jadwal Pelajaran</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="jadwalTable">
                            <thead>
                                <tr>
                                    <th>Jam</th>
                                    <th>Senin</th>
                                    <th>Selasa</th>
                                    <th>Rabu</th>
                                    <th>Kamis</th>
                                    <th>Jumat</th>
                                </tr>
                            </thead>
                            <tbody id="jadwalTableBody">
                                <!-- Data akan diisi oleh JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Modal Tambah Jadwal -->
<div class="modal fade" id="tambahJadwalModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Jadwal Pelajaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formTambahJadwal" onsubmit="handleSubmit(event)">
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
                        <label class="form-label">Hari</label>
                        <select class="form-select" name="hari" required>
                            <option value="">Pilih Hari</option>
                            <option value="Senin">Senin</option>
                            <option value="Selasa">Selasa</option>
                            <option value="Rabu">Rabu</option>
                            <option value="Kamis">Kamis</option>
                            <option value="Jumat">Jumat</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jam Pelajaran</label>
                        <select class="form-select" name="jam" required>
                            <option value="">Pilih Jam</option>
                            <option value="1">07:00 - 07:45</option>
                            <option value="2">07:45 - 08:30</option>
                            <option value="3">08:30 - 09:15</option>
                            <option value="4">09:30 - 10:15</option>
                            <option value="5">10:15 - 11:00</option>
                            <option value="6">11:00 - 11:45</option>
                            <option value="7">12:30 - 13:15</option>
                            <option value="8">13:15 - 14:00</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mata Pelajaran</label>
                        <select class="form-select" name="mata_pelajaran" required>
                            <option value="">Pilih Mata Pelajaran</option>
                            <option value="Matematika">Matematika</option>
                            <option value="Fisika">Fisika</option>
                            <option value="Kimia">Kimia</option>
                            <option value="Biologi">Biologi</option>
                            <option value="Sejarah">Sejarah</option>
                            <option value="Bahasa Indonesia">Bahasa Indonesia</option>
                            <option value="Bahasa Inggris">Bahasa Inggris</option>
                            <option value="Ekonomi">Ekonomi</option>
                            <option value="Geografi">Geografi</option>
                            <option value="Sosiologi">Sosiologi</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Guru Pengajar</label>
                        <select class="form-select" name="guru" required>
                            <option value="">Pilih Guru</option>
                            <!-- Opsi guru akan diisi oleh JavaScript -->
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" form="formTambahJadwal" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Data sementara untuk jadwal
    let jadwalData = [
        {
            kelas: 'X IPA 1',
            hari: 'Senin',
            jam: '07:00 - 07:45',
            mataPelajaran: 'Matematika',
            guru: 'Budi Santoso'
        },
        {
            kelas: 'X IPA 1',
            hari: 'Senin',
            jam: '07:45 - 08:30',
            mataPelajaran: 'Fisika',
            guru: 'Siti Aminah'
        }
    ];

    // Fungsi untuk menampilkan jadwal berdasarkan kelas yang dipilih
    function renderJadwalTable(kelas) {
        const tbody = $('#jadwalTableBody');
        tbody.empty();

        // Buat array jam pelajaran
        const jamPelajaran = [
            '07:00 - 07:45',
            '07:45 - 08:30',
            '08:30 - 09:15',
            '09:30 - 10:15',
            '10:15 - 11:00',
            '11:00 - 11:45',
            '12:30 - 13:15',
            '13:15 - 14:00'
        ];

        // Render baris untuk setiap jam pelajaran
        jamPelajaran.forEach((jam, index) => {
            let row = `<tr><td>${jam}</td>`;
            
            // Render sel untuk setiap hari
            ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'].forEach(hari => {
                const jadwal = jadwalData.find(j => 
                    j.kelas === kelas && 
                    j.hari === hari && 
                    j.jam === jam
                );

                if (jadwal) {
                    row += `
                        <td>
                            ${jadwal.mataPelajaran}<br>
                            <small class="text-muted">${jadwal.guru}</small>
                            <div class="mt-1">
                                <button class="btn btn-sm btn-warning" onclick="editJadwal('${kelas}','${hari}','${jam}')">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="deleteJadwal('${kelas}','${hari}','${jam}')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    `;
                } else {
                    row += '<td></td>';
                }
            });

            row += '</tr>';
            tbody.append(row);
        });
    }

    // Event handler untuk filter kelas
    $('#filterKelas').change(function() {
        const selectedKelas = $(this).val();
        if (selectedKelas) {
            renderJadwalTable(selectedKelas);
        }
    });

    // Inisialisasi DataTable
    $('#jadwalTable').DataTable({
        paging: false,
        searching: false
    });
});

// Fungsi-fungsi handler
function handleSubmit(event) {
    event.preventDefault();
    // Implementasi tambah jadwal
}

function editJadwal(kelas, hari, jam) {
    // Implementasi edit jadwal
}

function deleteJadwal(kelas, hari, jam) {
    // Implementasi hapus jadwal
}
</script>
@endsection
