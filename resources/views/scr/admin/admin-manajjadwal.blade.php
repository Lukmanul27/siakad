@extends('layouts.appadmin')

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
                                <select class="form-select" id="filterHari" name="hari" onchange="filterJadwal()">
                                    <option value="">Pilih Hari</option>
                                    <option value="Senin">Senin</option>
                                    <option value="Selasa">Selasa</option>
                                    <option value="Rabu">Rabu</option>
                                    <option value="Kamis">Kamis</option>
                                    <option value="Jumat">Jumat</option>
                                    <option value="Sabtu">Sabtu</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-danger" id="resetFilter" onclick="resetFilter()">Reset</button>
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
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="jadwalTableBody">
                                    @foreach ($jadwals as $index => $jadwal)
                                        <tr data-id="{{ $jadwal->id }}">
                                            <td class="hari">{{ $jadwal->hari }}</td>
                                            <td class="kelas">{{ $jadwal->kelas ? $jadwal->kelas->nama_kelas : 'Semua Kelas' }}</td>
                                            <td class="jam-ke">{{ $jadwal->jam_ke }}</td>
                                            <td class="waktu">{{ $jadwal->waktu }}</td>
                                            <td>{{ $jadwal->mataPelajaran ? $jadwal->mataPelajaran->nama : ($jadwal->mata_pelajaran_id == '90' ? 'Upacara' : ($jadwal->mata_pelajaran_id == '91' ? 'Istirahat' : 'Apel')) }}</td>
                                            <td>{{ $jadwal->guru ? $jadwal->guru->name : (isset($jadwal->guru_id) && $jadwal->guru_id == '94' ? '-' : 'Semuanya') }}</td>
                                            <td class="jurusan">{{ $jadwal->jurusan->nama_jurusan ?? 'Semua Jurusan' }}</td>
                                            <td>
                                                <button class="btn btn-warning edit-btn" data-id="{{ $jadwal->id }}" data-bs-toggle="modal" data-bs-target="#editJadwalModal{{ $jadwal->id }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <form action="{{ route('admin.jadwal.destroy', $jadwal->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger delete-btn" data-id="{{ $jadwal->id }}" onclick="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?')">
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
        function filterJadwal() {
            const filterHari = document.getElementById("filterHari").value;
            const rows = document.querySelectorAll("#jadwalTableBody tr");

            rows.forEach(row => {
                const hari = row.querySelector(".hari").textContent;
                const hariMatch = filterHari === "" || hari === filterHari;
                row.style.display = hariMatch ? "" : "none";
            });
        }

        function resetFilter() {
            document.getElementById("filterHari").value = "";
            filterJadwal();
        }
    </script>
@endsection
