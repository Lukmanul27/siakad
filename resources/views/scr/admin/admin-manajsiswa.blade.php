@extends('layouts.appadmin')

@section('title', 'Manajemen Siswa')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            @include('layouts.sidebar.admin-appsidebar')

            <!-- Konten Utama -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-3 mb-4 border-bottom">
                    <h1 class="h2 text-dark">Manajemen Siswa</h1>
                    <div>
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#tambahSiswaModal">
                            <i class="fas fa-plus"></i> Tambah Siswa
                        </button>
                    </div>
                </div>
                <div class="card shadow mb-4">
                    <div class="card-header py-3 bg-primary text-white">
                        <h6 class="m-0 font-weight-bold">Filter Siswa</h6>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label for="filterJurusan" class="form-label text-secondary">Jurusan</label>
                                <select class="form-select" id="filterJurusan" onchange="updateKelasOptions(); filterTable();">
                                    <option value="">Semua Jurusan</option>
                                    @foreach ($jurusans as $jurusan)
                                        <option value="{{ $jurusan->id }}">{{ $jurusan->nama_jurusan }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="filterKelas" class="form-label text-secondary">Kelas</label>
                                <select class="form-select" id="filterKelas" onchange="filterTable();">
                                    <option value="">Pilih Kelas Berdasarkan Jurusan</option>
                                </select>
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
                                <button class="btn btn-danger" id="resetFilter" onclick="resetFilter()">Reset</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabel Daftar Siswa -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center bg-primary text-white">
                        <h6 class="m-0 font-weight-bold">Daftar Siswa</h6>
                        <span class="badge bg-light text-dark">{{ $siswas->count() }} Siswa Terdaftar</span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" id="dataTable">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>NIS</th>
                                        <th>Nama</th>
                                        <th>Jurusan</th>
                                        <th>Kelas</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Alamat</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="siswaTableBody">
                                    @foreach ($siswas->sortBy('nis') as $siswa)
                                        <tr data-jurusan="{{ optional($siswa->jurusan)->id }}"
                                            data-kelas="{{ optional($siswa->kelas)->id }}">
                                            <td class="row-number"></td>
                                            <td>{{ $siswa->nis }}</td>
                                            <td>{{ $siswa->nama }}</td>
                                            <td>{{ optional($siswa->jurusan)->nama_jurusan ?? 'Tidak Ada Jurusan' }}</td>
                                            <td>{{ optional($siswa->kelas)->nama_kelas ?? 'Tidak Ada Kelas' }}</td>
                                            <td>{{ $siswa->jenis_kelamin }}</td>
                                            <td>{{ $siswa->alamat }}</td>
                                            <td>
                                                <button class="btn btn-warning" data-bs-toggle="modal"
                                                    data-bs-target="#editSiswaModal" data-id="{{ $siswa->id }}"
                                                    data-nis="{{ $siswa->nis }}" data-nama="{{ $siswa->nama }}"
                                                    data-jurusan="{{ optional($siswa->jurusan)->id }}"
                                                    data-kelas="{{ optional($siswa->kelas)->id }}"
                                                    data-jenis_kelamin="{{ $siswa->jenis_kelamin }}"
                                                    data-alamat="{{ $siswa->alamat }}" onclick="setEditData(this)">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <form action="{{ route('admin.siswa.destroy', $siswa->id) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger"
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus siswa ini?')">
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

    @include('layouts.modals.admin-siswa')

    <script>
        function updateKelasOptions() {
            const jurusanId = document.getElementById('filterJurusan').value;
            const kelasSelect = document.getElementById('filterKelas');
            kelasSelect.innerHTML = '<option value="">Pilih Kelas Berdasarkan Jurusan</option>'; // Reset options

            @foreach ($kelas as $k)
                if ({{ $k->jurusan_id }} == jurusanId) {
                    const option = document.createElement('option');
                    option.value = '{{ $k->id }}';
                    option.textContent = '{{ $k->nama_kelas }}';
                    kelasSelect.appendChild(option);
                }
            @endforeach
        }

        function updateKelasOptionsTambah() {
            const jurusanId = document.getElementById('tambahJurusan').value;
            const kelasSelect = document.getElementById('tambahKelas');
            kelasSelect.innerHTML = '<option value="">Pilih Kelas Berdasarkan Jurusan</option>'; // Reset options

            @foreach ($kelas as $k)
                if ({{ $k->jurusan_id }} == jurusanId) {
                    const option = document.createElement('option');
                    option.value = '{{ $k->id }}';
                    option.textContent = '{{ $k->nama_kelas }}';
                    kelasSelect.appendChild(option);
                }
            @endforeach
        }

        function updateKelasOptionsEdit() {
            const jurusanId = document.getElementById('editJurusan').value;
            const kelasSelect = document.getElementById('editKelas');
            kelasSelect.innerHTML = '<option value="">Pilih Kelas Berdasarkan Jurusan</option>'; // Reset options

            @foreach ($kelas as $k)
                if ({{ $k->jurusan_id }} == jurusanId) {
                    const option = document.createElement('option');
                    option.value = '{{ $k->id }}';
                    option.textContent = '{{ $k->nama_kelas }}';
                    kelasSelect.appendChild(option);
                }
            @endforeach
        }

        document.getElementById('filterJurusan').addEventListener('change', filterTable);
        document.getElementById('filterKelas').addEventListener('change', filterTable);

        function filterTable() {
            const jurusanFilter = document.getElementById('filterJurusan').value;
            const kelasFilter = document.getElementById('filterKelas').value;
            const rows = document.querySelectorAll('#siswaTableBody tr');

            rows.forEach(row => {
                const jurusan = row.getAttribute('data-jurusan');
                const kelas = row.getAttribute('data-kelas');

                row.style.display = (jurusanFilter === '' || jurusan === jurusanFilter) && (kelasFilter === '' ||
                    kelas === kelasFilter) ? '' : 'none';
            });

            resetNo(); // Reset nomor urut setelah filter
        }

        function resetNo() {
            const rows = document.querySelectorAll('#siswaTableBody tr');
            let count = 1; // Initialize count for numbering
            rows.forEach(row => {
                if (row.style.display !== 'none') {
                    row.querySelector('.row-number').textContent = count++; // Increment count for visible rows
                } else {
                    row.querySelector('.row-number').textContent = ''; // Clear number for hidden rows
                }
            });
        }

        function setEditData(button) {
            document.getElementById('editSiswaId').value = button.getAttribute('data-id');
            document.getElementById('editNis').value = button.getAttribute('data-nis');
            document.getElementById('editNama').value = button.getAttribute('data-nama');
            document.getElementById('editJurusan').value = button.getAttribute('data-jurusan');
            updateKelasOptionsEdit(); // Update kelas options based on jurusan
            document.getElementById('editKelas').value = button.getAttribute('data-kelas');
            document.getElementById('editJenisKelamin').value = button.getAttribute('data-jenis_kelamin');
            document.getElementById('editAlamat').value = button.getAttribute('data-alamat');
        }

        document.getElementById('resetFilter').addEventListener('click', function() {
            const jurusanSelect = document.getElementById('filterJurusan');
            const kelasSelect = document.getElementById('filterKelas');
            jurusanSelect.value = '';
            kelasSelect.innerHTML = '<option value="">Pilih Kelas Berdasarkan Jurusan</option>'; // Reset options
            filterTable();
        });
    </script>
@endsection
