 @extends('layouts.appadmin')

@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('layouts.sidebar.admin-appsidebar')

            <main class="col-12 col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Manajemen Jurusan & Kelas</h1>
                </div>

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Daftar Jurusan</h6>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#tambahJurusanModal">
                            <i class="fas fa-plus"></i> Tambah
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="jurusanTable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Jurusan</th>
                                        <th>Nama Jurusan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($jurusans as $index => $jurusan)
                                        <tr>
                                            <td class="row-number">{{ $loop->iteration }}</td>
                                            <td>{{ $jurusan->kode_jurusan }}</td>
                                            <td>{{ $jurusan->nama_jurusan }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editJurusanModal{{ $jurusan->id }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <form action="{{ route('jurusan.delete', $jurusan->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus jurusan ini?')">
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

                @include('layouts.modals.admin-jurusan')

                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Manajemen Kelas</h1>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahKelasModal">
                        <i class="fas fa-plus"></i> Tambah
                    </button>
                </div>

                <div class="card shadow mb-4">
                    <div class="card-body">
                        <label class="form-label">Filter Kelas</label>
                        <div class="row align-items-center">
                            <div class="col-12 col-md-3 mb-3">
                                <select class="form-select" id="filterTingkat" onchange="filterKelas()">
                                    <option value="">Semua Tingkat</option>
                                    <option value="X">X</option>
                                    <option value="XI">XI</option>
                                    <option value="XII">XII</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-3 mb-3">
                                <select class="form-select" id="filterJurusan" onchange="filterKelas()">
                                    <option value="">Semua Jurusan</option>
                                    @foreach ($jurusans as $jurusan)
                                        <option value="{{ $jurusan->id }}">{{ $jurusan->nama_jurusan }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-md-3 mb-3">
                                <select class="form-select" id="filterWaliKelas" onchange="filterKelas()">
                                    <option value="">Semua Wali Kelas</option>
                                    @foreach ($waliKelas as $wali)
                                        <option value="{{ $wali->id }}">{{ $wali->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-md-3 mb-3">
                                <button class="btn btn-danger w-100" onclick="resetFilter()">Reset Filter</button>
                            </div>
                        </div>
                    </div>

                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Daftar Kelas</h6>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="kelasTable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tingkat</th>
                                        <th>Jurusan</th>
                                        <th>Wali Kelas</th>
                                        <th>Nama Kelas</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="kelasTableBody">
                                    @foreach ($kelas->sortBy('jurusan_id') as $kelasItem)
                                        <tr class="kelas-row" data-tingkat="{{ $kelasItem->tingkat }}" data-jurusan-id="{{ $kelasItem->jurusan_id }}" data-wali-id="{{ $kelasItem->wali_kelas }}">
                                            <td class="row-number">{{ $loop->iteration }}</td>
                                            <td>{{ $kelasItem->tingkat }}</td>
                                            <td>{{ $kelasItem->jurusan->nama_jurusan }}</td>
                                            <td>{{ $kelasItem->waliKelas ? $kelasItem->waliKelas->name : 'Tidak ada' }}</td>
                                            <td>{{ $kelasItem->nama_kelas }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editKelasModal{{ $kelasItem->id }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <form action="{{ route('kelas.destroy', $kelasItem->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus kelas ini?')">
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

@include('layouts.modals.admin-kelas')

<script>
    function filterKelas() {
        const filterTingkat = document.getElementById("filterTingkat").value;
        const filterJurusan = document.getElementById("filterJurusan").value;
        const filterWaliKelas = document.getElementById("filterWaliKelas").value;
        const rows = document.querySelectorAll("#kelasTableBody .kelas-row");

        rows.forEach(row => {
            const tingkat = row.getAttribute("data-tingkat");
            const jurusanId = row.getAttribute("data-jurusan-id");
            const waliId = row.getAttribute("data-wali-id");

            row.style.display = (filterTingkat === "" || tingkat === filterTingkat) &&
                                (filterJurusan === "" || jurusanId === filterJurusan) &&
                                (filterWaliKelas === "" || waliId === filterWaliKelas) ? "" : "none";
        });
        resetNo();
    }

    function resetNo() {
        const rows = document.querySelectorAll('#kelasTableBody .kelas-row'); 
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
        document.getElementById("filterTingkat").value = "";
        document.getElementById("filterJurusan").value = "";
        document.getElementById("filterWaliKelas").value = "";
        filterKelas();
    }
</script>
@endsection
