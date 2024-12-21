@extends('layouts.appadmin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        @include('layouts.sidebar.admin-appsidebar')

        <!-- Konten Utama -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Manajemen Siswa</h1>
                <div>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahSiswaModal">
                        <i class="fas fa-plus"></i> Tambah Siswa
                    </button>
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-3">
                            <select class="form-select" id="filterJurusan" onchange="updateKelasOptions(); filterTable();">
                                <option value="">Semua Jurusan</option>
                                @foreach($jurusans as $jurusan)
                                    <option value="{{ $jurusan->id }}">{{ $jurusan->nama_jurusan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="filterKelas" onchange="filterTable();">
                                <option value="">Pilih Kelas Berdasarkan Jurusan</option>
                                <!-- Kelas akan diisi berdasarkan jurusan yang dipilih -->
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
                                    <th>Jurusan</th>
                                    <th>Kelas</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Alamat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="siswaTableBody">
                                @foreach($siswas->sortBy('nis') as $siswa)
                                <tr data-jurusan="{{ optional($siswa->jurusan)->id }}" data-kelas="{{ optional($siswa->kelas)->id }}">
                                    <td class="row-number"></td>
                                    <td>{{ $siswa->nis }}</td>
                                    <td>{{ $siswa->nama }}</td>
                                    <td>{{ optional($siswa->jurusan)->nama_jurusan ?? 'Tidak Ada Jurusan' }}</td>
                                    <td>{{ optional($siswa->kelas)->nama_kelas ?? 'Tidak Ada Kelas' }}</td>
                                    <td>{{ $siswa->jenis_kelamin }}</td>
                                    <td>{{ $siswa->alamat }}</td>
                                    <td>
                                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editSiswaModal" 
                                            data-id="{{ $siswa->id }}" 
                                            data-nis="{{ $siswa->nis }}" 
                                            data-nama="{{ $siswa->nama }}" 
                                            data-jurusan="{{ optional($siswa->jurusan)->id }}" 
                                            data-kelas="{{ optional($siswa->kelas)->id }}" 
                                            data-jenis_kelamin="{{ $siswa->jenis_kelamin }}" 
                                            data-alamat="{{ $siswa->alamat }}"
                                            onclick="setEditData(this)">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('admin.siswa.destroy', $siswa->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus siswa ini?')">
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

<!-- Modal Tambah Siswa -->
<section>
    <div class="modal fade" id="tambahSiswaModal" tabindex="-1" aria-labelledby="tambahSiswaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahSiswaModalLabel">Tambah Siswa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('admin.siswa.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="nis" class="form-label">NIS</label>
                            <input type="text" class="form-control" name="nis" required>
                        </div>
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="jurusan_id" class="form-label">Jurusan</label>
                            <select class="form-select" name="jurusan_id" id="tambahJurusan" onchange="updateKelasOptionsTambah()" required>
                                <option value="">Pilih Jurusan</option>
                                @foreach($jurusans as $jurusan)
                                    <option value="{{ $jurusan->id }}">{{ $jurusan->nama_jurusan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="kelas_id" class="form-label">Kelas</label>
                            <select class="form-select" name="kelas_id" id="tambahKelas" required>
                                <option value="">Pilih Kelas</option>
                                <!-- Kelas akan diisi berdasarkan jurusan yang dipilih -->
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                            <select class="form-select" name="jenis_kelamin" required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea class="form-control" name="alamat" rows="3" required></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal Edit Siswa -->
<section>
    <div class="modal fade" id="editSiswaModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Siswa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="formEditSiswa" method="POST" action="{{ route('admin.siswa.update', 'siswa_id') }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" id="editSiswaId">
                        <div class="mb-3">
                            <label class="form-label">NIS</label>
                            <input type="text" class="form-control" name="nis" id="editNis" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" name="nama" id="editNama" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jurusan</label>
                            <select class="form-select" name="jurusan_id" id="editJurusan" onchange="updateKelasOptionsEdit()" required>
                                <option value="">Pilih Jurusan</option>
                                @foreach($jurusans as $jurusan)
                                    <option value="{{ $jurusan->id }}">{{ $jurusan->nama_jurusan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kelas</label>
                            <select class="form-select" name="kelas_id" id="editKelas" required>
                                <option value="">Pilih Kelas</option>
                                <!-- Kelas akan diisi berdasarkan jurusan yang dipilih -->
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jenis Kelamin</label>
                            <select class="form-select" name="jenis_kelamin" id="editJenisKelamin" required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea class="form-control" name="alamat" id="editAlamat" rows="3" required></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" form="formEditSiswa" class="btn btn-primary" onclick="event.preventDefault(); document.getElementById('formEditSiswa').setAttribute('action', '{{ route('admin.siswa.update', 'siswa_id') }}'.replace('siswa_id', document.getElementById('editSiswaId').value)); document.getElementById('formEditSiswa').submit();">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    function updateKelasOptions() {
        const jurusanId = document.getElementById('filterJurusan').value;
        const kelasSelect = document.getElementById('filterKelas');
        kelasSelect.innerHTML = '<option value="">Pilih Kelas Berdasarkan Jurusan</option>'; // Reset options

        @foreach($kelas as $k)
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

        @foreach($kelas as $k)
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

        @foreach($kelas as $k)
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

            row.style.display = (jurusanFilter === '' || jurusan === jurusanFilter) && (kelasFilter === '' || kelas === kelasFilter) ? '' : 'none';
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
</script>

@endsection