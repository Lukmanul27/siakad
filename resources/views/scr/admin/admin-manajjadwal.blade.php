@extends('layouts.appadmin')

@section('title', 'Manajemen Jadwal Pelajaran')
@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('layouts.sidebar.admin-appsidebar')

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2 text-dark">Manajemen Jadwal Pelajaran</h1>
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#tambahJadwalModal">
                        <i class="fas fa-plus"></i> Tambah Jadwal
                    </button>
                </div>

                <div class="card shadow mb-4">
                    <div class="card-header py-3 bg-primary text-white">
                        <h6 class="m-0 font-weight-bold">Filter Jadwal</h6>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-center mb-3">
                            <div class="col-md-3">
                                <select class="form-select" id="filterHari" name="hari">
                                    <option value="">Pilih Hari</option>
                                    @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $hari)
                                        <option value="{{ $hari }}">{{ $hari }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-danger" id="resetFilter">Reset</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow mb-4">
                    <div class="card-header py-3 bg-primary text-white">
                        <h6 class="m-0 font-weight-bold">Jadwal Pelajaran</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" id="jadwalTable">
                                <thead class="table-light">
                                    <tr>
                                        <th>Hari</th>
                                        <th>Kelas</th>
                                        <th>Jam Ke</th>
                                        <th>Waktu</th>
                                        <th>Mata Pelajaran</th>
                                        <th>Guru Mata Pelajaran</th>
                                        <th>Jurusan</th>
                                        <th>Ruangan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="jadwalTableBody">
                                    @foreach ($jadwals as $jadwal)
                                        <tr data-id="{{ $jadwal->id }}">
                                            <td class="hari">{{ $jadwal->hari }}</td>
                                            <td class="kelas">{{ $jadwal->kelas->nama_kelas ?? 'Semua Kelas' }}</td>
                                            <td class="jam-ke">{{ $jadwal->jam_ke }}</td>
                                            <td class="waktu">{{ $jadwal->waktu }}</td>
                                            <td>{{ $jadwal->mataPelajaran->nama ?? ($jadwal->mata_pelajaran_id == '90' ? 'Upacara' : ($jadwal->mata_pelajaran_id == '91' ? 'Istirahat' : 'Apel')) }}</td>
                                            <td>{{ $jadwal->guru->name ?? ($jadwal->guru_id == '94' ? '-' : 'Semuanya') }}</td>
                                            <td class="jurusan">{{ $jadwal->jurusan->nama_jurusan ?? 'Semua Jurusan' }}</td>
                                            <td class="ruangan">{{ $jadwal->ruangan ?? 'Belum Ditentukan' }}</td>
                                            <td>
                                                <button class="btn btn-warning edit-btn" data-id="{{ $jadwal->id }}"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editJadwalModal{{ $jadwal->id }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <form action="{{ route('admin.jadwal.destroy', $jadwal->id) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger delete-btn"
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    @include('layouts.modals.admin-jadwals')

    <script>
        document.getElementById('filterHari').addEventListener('change', function() {
            filterJadwal(this.value);
        });

        document.getElementById('resetFilter').addEventListener('click', function() {
            document.getElementById('filterHari').value = '';
            filterJadwal('');
        });

        function filterJadwal(hari) {
            const rows = document.querySelectorAll('#jadwalTableBody tr');
            rows.forEach(row => {
                const rowHari = row.querySelector('.hari').textContent;
                row.style.display = (hari === '' || rowHari === hari) ? '' : 'none';
            });
        }

        function toggleFields() {
            const jurusanId = document.getElementById('jurusanSelect').value;
            const kelasContainer = document.getElementById('kelasContainer');
            const jamKeContainer = document.getElementById('jamKeContainer');
            const waktuContainer = document.getElementById('waktuContainer');
            const mataPelajaranContainer = document.getElementById('mataPelajaranContainer');
            const mataPelajaranSelect = document.getElementById('mataPelajaranSelect');
            const guruSelect = document.getElementById('guruSelect');
            const kelasSelect = document.getElementById('kelasSelect');

            if (jurusanId) {
                kelasContainer.style.display = 'block';
                jamKeContainer.style.display = 'block';
                waktuContainer.style.display = 'block';
                mataPelajaranContainer.style.display = 'block';
                mataPelajaranSelect.innerHTML = '<option value="">Pilih Mata Pelajaran</option>';

                if (jurusanId === "0") {
                    mataPelajaranSelect.innerHTML = '<option value="90">Upacara</option>' +
                        '<option value="91">Istirahat</option>' +
                        '<option value="92">Apel</option>';
                    guruSelect.innerHTML = '<option value="93">Semua Guru</option>' +
                        '<option value="94"> - </option>';
                    Array.from(kelasSelect.options).forEach(option => option.selected = true);
                } else {
                    guruSelect.disabled = false;
                    guruSelect.innerHTML = '<option value="">Pilih Guru</option>';

                    @foreach ($mapels as $mapel)
                        if ({{ $mapel->jurusan_id }} == jurusanId) {
                            mataPelajaranSelect.innerHTML +=
                                '<option value="{{ $mapel->id }}">{{ $mapel->nama }}</option>';
                        }
                    @endforeach

                    @foreach ($gurus as $guru)
                        guruSelect.innerHTML += '<option value="{{ $guru->id }}">{{ $guru->name }}</option>';
                    @endforeach

                    Array.from(kelasSelect.options).forEach(option => {
                        option.style.display = option.getAttribute('data-jurusan') === jurusanId ? 'block' : 'none';
                    });
                }
            } else {
                kelasContainer.style.display = 'none';
                jamKeContainer.style.display = 'none';
                waktuContainer.style.display = 'none';
                mataPelajaranContainer.style.display = 'none';
                guruSelect.style.display = 'none';
            }
            filterJadwal();
        }

        document.getElementById('jurusanSelect').addEventListener('change', function(event) {
            toggleFields();
            filterJadwal();
            event.preventDefault();
        });

        document.getElementById('resetForm').addEventListener('click', function() {
            document.getElementById('formTambahJadwal').reset();
            ['kelasContainer', 'jamKeContainer', 'waktuContainer', 'mataPelajaranContainer'].forEach(id => {
                document.getElementById(id).style.display = 'none';
            });
            document.getElementById('guruSelect').disabled = false;
            filterJadwal();
        });
    </script>
