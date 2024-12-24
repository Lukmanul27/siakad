@extends('layouts.appguru')

@section('title', 'Daftar Hadir Siswa')
@section('content')
<div class="container-fluid">
    <div class="row">
        @include('layouts.sidebar.guru-appsidebar')
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Daftar Kehadiran Siswa</h1>
            </div>

            <div class="card shadow">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Kelas: <span id="selectedKelas"></span> | 
                        Mata Pelajaran: <span id="selectedMapel"></span> |
                        Tanggal: <span id="selectedTanggal"></span>
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NIS</th>
                                    <th>Nama Siswa</th>
                                    <th>Hadir</th>
                                    <th>Sakit</th>
                                    <th>Izin</th>
                                    <th>Alpha</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody id="studentList">
                                <!-- Data siswa akan dimuat di sini -->
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-end mt-3">
                        <button type="button" class="btn btn-secondary me-2" onclick="window.history.back()">Kembali</button>
                        <button type="submit" class="btn btn-primary">Simpan Presensi</button>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mengambil parameter dari URL
    const urlParams = new URLSearchParams(window.location.search);
    const kelas = urlParams.get('kelas');
    const mapel = urlParams.get('matapelajaran');
    const tanggal = urlParams.get('tanggal');

    // Menampilkan informasi yang dipilih
    document.getElementById('selectedKelas').textContent = kelas || '-';
    document.getElementById('selectedMapel').textContent = mapel || '-';
    document.getElementById('selectedTanggal').textContent = tanggal || '-';

    // Data sementara siswa berdasarkan kelas
    const dummyData = {
        'X-IPA1': [
            {nis: '1001', nama: 'Ahmad Rizki'},
            {nis: '1002', nama: 'Budi Santoso'},
            {nis: '1003', nama: 'Citra Dewi'},
            {nis: '1004', nama: 'Dian Purnama'},
            {nis: '1005', nama: 'Eko Prasetyo'}
        ],
        'X-IPA2': [
            {nis: '2001', nama: 'Fani Wijaya'},
            {nis: '2002', nama: 'Gunawan'},
            {nis: '2003', nama: 'Hadi Kusuma'},
            {nis: '2004', nama: 'Indah Pertiwi'},
            {nis: '2005', nama: 'Joko Widodo'}
        ],
        'XI-IPA1': [
            {nis: '3001', nama: 'Kartika Sari'},
            {nis: '3002', nama: 'Lukman Hakim'},
            {nis: '3003', nama: 'Maya Angelina'},
            {nis: '3004', nama: 'Nadia Putri'},
            {nis: '3005', nama: 'Oscar Pratama'}
        ]
    };

    // Memuat data siswa sesuai kelas yang dipilih
    const studentList = document.getElementById('studentList');
    if (kelas && dummyData[kelas]) {
        dummyData[kelas].forEach((siswa, index) => {
            studentList.innerHTML += `
                <tr>
                    <td>${index + 1}</td>
                    <td>${siswa.nis}</td>
                    <td>${siswa.nama}</td>
                    <td class="text-center">
                        <input type="radio" class="form-check-input" name="kehadiran_${siswa.nis}" value="H">
                    </td>
                    <td class="text-center">
                        <input type="radio" class="form-check-input" name="kehadiran_${siswa.nis}" value="S">
                    </td>
                    <td class="text-center">
                        <input type="radio" class="form-check-input" name="kehadiran_${siswa.nis}" value="I">
                    </td>
                    <td class="text-center">
                        <input type="radio" class="form-check-input" name="kehadiran_${siswa.nis}" value="A">
                    </td>
                    <td>
                        <input type="text" class="form-control form-control-sm" placeholder="Tambahkan keterangan...">
                    </td>
                </tr>
            `;
        });
    }
});
</script>
@endsection
