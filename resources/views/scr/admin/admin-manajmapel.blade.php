@extends('layouts.appadmin')

@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('layouts.sidebar.admin-appsidebar')

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2 text-dark">Manajemen Mata Pelajaran</h1>
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#tambahMapelModal">
                        <i class="fas fa-plus"></i> Tambah Mata Pelajaran
                    </button>
                </div>

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <div class="card shadow mb-4">
                    <div class="card-header py-3 bg-primary text-white">
                        <h6 class="m-0 font-weight-bold">Filter Jurusan</h6>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="filterJurusan" class="form-label">Jurusan</label>
                                <select class="form-select" id="filterJurusan" onchange="filterMapel()">
                                    <option value="">Semua Jurusan</option>
                                    @foreach ($jurusans as $jurusan)
                                        <option value="{{ $jurusan->id }}">{{ $jurusan->nama_jurusan }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
                                <button class="btn btn-danger" id="resetFilter" onclick="resetFilter()">Reset</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow mb-4">
                    <div class="card-header bg-primary text-white py-3">
                        <h6 class="m-0 font-weight-bold">Daftar Mata Pelajaran</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered" id="dataTable">
                                <thead class="table-light">
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
                                    @foreach ($mataPelajaran as $index => $mapel)
                                        <tr class="mapel-row" data-jurusan-id="{{ $mapel->jurusan_id }}">
                                            <td class="row-number">{{ $loop->iteration }}</td>
                                            <td>{{ $mapel->kode }}</td>
                                            <td>{{ $mapel->nama }}</td>
                                            <td>{{ $mapel->jurusan->nama_jurusan }}</td>
                                            <td>{{ $mapel->kkm }}</td>
                                            <td>
                                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#editMapelModal{{ $mapel->id }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <form action="{{ route('admin.mapel.destroy', $mapel->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus mata pelajaran ini?')">
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
                </div>
            </main>
        </div>
    </div>

    @include('layouts.modals.admin-mapel')

    <script>
        function filterMapel() {
            var filterValue = document.getElementById("filterJurusan").value;
            var rows = document.querySelectorAll("#mapelTableBody .mapel-row");

            rows.forEach(function(row) {
                if (filterValue === "" || row.getAttribute("data-jurusan-id") === filterValue) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
            resetNo();
        }

        function resetNo() {
            const rows = document.querySelectorAll('#mapelTableBody .mapel-row'); 
            let count = 1;
            rows.forEach(row => {
                if (row.style.display !== 'none') {
                    row.querySelector('.row-number').textContent = count++;
                } else {
                    row.querySelector('.row-number').textContent = '';
                }
            });
        }

        function resetFilter() {
            document.getElementById('filterJurusan').selectedIndex = 0;
            filterMapel(); // Panggil fungsi filter untuk menyegarkan tabel
        }
    </script>
@endsection
