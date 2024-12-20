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

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Filter Jurusan -->
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-3">
                            <select class="form-select" id="filterJurusan" onchange="filterMapel()">
                                <option value="">Semua Jurusan</option>
                                @foreach($jurusans as $jurusan)
                                    <option value="{{ $jurusan->id }}">{{ $jurusan->nama_jurusan }}</option>
                                @endforeach
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
                                @foreach($mataPelajaran as $index => $mapel)
                                <tr class="mapel-row" data-jurusan-id="{{ $mapel->jurusan_id }}">
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $mapel->kode }}</td>
                                    <td>{{ $mapel->nama }}</td>
                                    <td>{{ $mapel->jurusan->nama_jurusan }}</td>
                                    <td>{{ $mapel->kkm }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editMapelModal{{ $mapel->id }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('admin.mapel.destroy', $mapel->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus mata pelajaran ini?')">
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

<!-- Modal Edit Mata Pelajaran -->
@foreach($mataPelajaran as $mapel)
<div class="modal fade" id="editMapelModal{{ $mapel->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Mata Pelajaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formEditMapel{{ $mapel->id }}" action="{{ route('admin.mapel.update', $mapel->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Kode Mata Pelajaran</label>
                        <input type="text" class="form-control" name="kode" value="{{ $mapel->kode }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Mata Pelajaran</label>
                        <input type="text" class="form-control" name="nama" value="{{ $mapel->nama }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jurusan</label>
                        <select class="form-select" name="jurusan_id" required>
                            <option value="">Pilih Jurusan</option>
                            @foreach($jurusans as $jurusan)
                                <option value="{{ $jurusan->id }}" {{ $jurusan->id == $mapel->jurusan_id ? 'selected' : '' }}>{{ $jurusan->nama_jurusan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">KKM</label>
                        <input type="number" class="form-control" name="kkm" value="{{ $mapel->kkm }}" min="0" max="100" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" form="formEditMapel{{ $mapel->id }}" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>
@endforeach

<!-- Modal Tambah Mata Pelajaran -->
<div class="modal fade" id="tambahMapelModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Mata Pelajaran Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formTambahMapel" action="{{ route('admin.mapel.store') }}" method="POST">
                    @csrf
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
                        <select class="form-select" name="jurusan_id" required>
                            <option value="">Pilih Jurusan</option>
                            @foreach($jurusans as $jurusan)
                                <option value="{{ $jurusan->id }}">{{ $jurusan->nama_jurusan }}</option>
                            @endforeach
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
    }
</script>

@endsection