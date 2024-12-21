@extends('layouts.appadmin')

@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('layouts.sidebar.admin-appsidebar')

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Manajemen Jadwal Pelajaran</h1>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahJadwalModal">
                        <i class="fas fa-plus"></i> Tambah Jadwal
                    </button>
                </div>

                <div class="card shadow mb-4">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-3">
                                <select class="form-select" id="filterKelas" name="kelas_id">
                                    <option value="">Pilih Kelas</option>
                                    @foreach ($kelas as $k)
                                        <option value="{{ $k->id }}" data-jurusan="{{ $k->jurusan_id }}">
                                            {{ $k->nama_kelas }}</option>
                                    @endforeach
                                    <option value="all">Seluruh Kelas</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Jadwal Pelajaran</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="jadwalTable">
                                <thead>
                                    <tr>
                                        <th>Hari</th>
                                        <th>Kelas</th>
                                        <th>Jam Ke</th>
                                        <th>Waktu</th>
                                        <th>Mata Pelajaran</th>
                                        <th>Guru Mata Pelajaran</th>
                                        <th>Jurusan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="jadwalTableBody">
                                    @foreach ($jadwals as $jadwal)
                                        <tr>
                                            <td>{{ $jadwal->hari }}</td>
                                            <td>{{ $jadwal->kelas->nama_kelas }}</td>
                                            <td>{{ $jadwal->jam_ke }}</td>
                                            <td>{{ $jadwal->waktu }}</td>
                                            <td>{{ $jadwal->mataPelajaran->nama_mapel }}</td>
                                            <td>{{ $jadwal->guru->name }}</td>
                                            <td>{{ $jadwal->jurusan->nama_jurusan ?? 'Tidak Diketahui' }}</td>
                                            <td>
                                                <button class="btn btn-warning" data-bs-toggle="modal"
                                                    data-bs-target="#editJadwalModal{{ $jadwal->id }}">Edit</button>
                                                <form action="{{ route('admin.jadwal.destroy', $jadwal->id) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Hapus</button>
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

    <div class="modal fade" id="tambahJadwalModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Jadwal Pelajaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="formTambahJadwal" action="{{ route('admin.jadwal.store') }}" method="POST">
                        @csrf

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="mb-3">
                            <label class="form-label">Hari</label>
                            <select class="form-select" name="hari" required>
                                <option value="">Pilih Hari</option>
                                @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $hari)
                                    <option value="{{ $hari }}">{{ $hari }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jurusan</label>
                            <select class="form-select" id="jurusanSelect" name="jurusan_id" required
                                onchange="toggleFields()">
                                <option value="">Pilih Jurusan</option>
                                <option value="0">Seluruh Jurusan</option>
                                @foreach ($jurusans as $jurusan)
                                    <option value="{{ $jurusan->id }}">{{ $jurusan->nama_jurusan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3" id="kelasContainer" style="display: none;">
                            <label class="form-label">Kelas</label>
                            <select class="form-select" id="kelasSelect" name="kelas_id" required>
                                <option value="">Pilih Kelas</option>
                                @foreach ($kelas as $k)
                                    <option value="{{ $k->id }}" data-jurusan="{{ $k->jurusan_id }}">
                                        {{ $k->nama_kelas }}</option>
                                @endforeach
                                <option value="all">Seluruh Kelas</option>
                            </select>
                        </div>
                        <div class="mb-3" id="jamKeContainer" style="display: none;">
                            <label class="form-label">Jam Ke</label>
                            <select class="form-select" name="jam_ke" required>
                                <option value="">Pilih Jam</option>
                                @for ($i = 1; $i <= 10; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="mb-3" id="waktuContainer" style="display: none;">
                            <label class="form-label">Waktu</label>
                            <select class="form-select" name="waktu" required>
                                <option value="">Pilih Waktu</option>
                                @for ($i = 0; $i < 10; $i++)
                                    <option value="{{ date('H:i', strtotime('07:20') + $i * 45 * 60) }}">
                                        {{ date('H:i', strtotime('07:20') + $i * 45 * 60) }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="mb-3" id="mataPelajaranContainer" style="display: none;">
                            <label class="form-label">Mata Pelajaran</label>
                            <select class="form-select" id="mataPelajaranSelect" name="mata_pelajaran_id" required>
                                <option value="">Pilih Mata Pelajaran</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Guru Pengajar</label>
                            <select class="form-select" id="guruSelect" name="guru_id" required>
                                <option value="">Pilih Guru</option>
                                @foreach ($gurus as $guru)
                                    <option value="{{ $guru->id }}">{{ $guru->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" id="resetForm">Reset</button>
                    <button type="submit" form="formTambahJadwal" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <script>
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
                    mataPelajaranSelect.innerHTML += '<option value="upacara">Upacara</option>';
                    mataPelajaranSelect.innerHTML += '<option value="istirahat">Istirahat</option>';
                    mataPelajaranSelect.innerHTML += '<option value="apel">Apel</option>';
                    guruSelect.disabled = true;

                    Array.from(kelasSelect.options).forEach(option => option.selected = true);
                } else {
                    guruSelect.disabled = false;
                    @foreach ($mapels as $mapel)
                        if ({{ $mapel->jurusan_id }} == jurusanId) {
                            mataPelajaranSelect.innerHTML +=
                                '<option value="{{ $mapel->id }}">{{ $mapel->nama }}</option>';
                        }
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
                guruSelect.disabled = false;
            }
        }

        document.getElementById('jurusanSelect').addEventListener('change', function(event) {
            toggleFields();
            event.preventDefault(); // Mencegah pengiriman form saat mengubah jurusan
        });

        document.getElementById('resetForm').addEventListener('click', function() {
            document.getElementById('formTambahJadwal').reset();
            ['kelasContainer', 'jamKeContainer', 'waktuContainer', 'mataPelajaranContainer'].forEach(id => {
                document.getElementById(id).style.display = 'none';
            });
            document.getElementById('guruSelect').disabled = false;
        });
    </script>
@endsection
