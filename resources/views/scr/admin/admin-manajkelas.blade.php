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
                                            <td>{{ $index + 1 }}</td>
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

                @foreach ($jurusans as $jurusan)
                    <div class="modal fade" id="editJurusanModal{{ $jurusan->id }}" tabindex="-1" aria-labelledby="editJurusanModalLabel{{ $jurusan->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editJurusanModalLabel{{ $jurusan->id }}">Edit Jurusan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('jurusan.update', $jurusan->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Kode</label>
                                            <input type="text" class="form-control" name="kode_jurusan" value="{{ $jurusan->kode_jurusan }}" required maxlength="10">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Nama</label>
                                            <input type="text" class="form-control" name="nama_jurusan" value="{{ $jurusan->nama_jurusan }}" required maxlength="255">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="modal fade" id="tambahJurusanModal" tabindex="-1" aria-labelledby="tambahJurusanModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="tambahJurusanModalLabel">Tambah Jurusan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('jurusan.store') }}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">Kode</label>
                                        <input type="text" class="form-control" name="kode_jurusan" required maxlength="10">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Nama</label>
                                        <input type="text" class="form-control" name="nama_jurusan" required maxlength="255">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

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
                                    @foreach ($kelas as $index => $kelasItem)
                                        <tr class="kelas-row" data-tingkat="{{ $kelasItem->tingkat }}" data-jurusan-id="{{ $kelasItem->jurusan_id }}" data-wali-id="{{ $kelasItem->wali_kelas }}">
                                            <td>{{ $index + 1 }}</td>
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

<div class="modal fade" id="tambahKelasModal" tabindex="-1" aria-labelledby="tambahKelasModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahKelasModalLabel">Tambah Kelas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('kelas.store') }}" method="POST" id="formTambahKelas">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Tingkat</label>
                        <select class="form-select" name="tingkat" required>
                            <option value="">Pilih Tingkat</option>
                            <option value="X">X</option>
                            <option value="XI">XI</option>
                            <option value="XII">XII</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jurusan</label>
                        <select class="form-select" name="jurusan_id" required>
                            <option value="">Pilih Jurusan</option>
                            @foreach ($jurusans as $jurusan)
                                <option value="{{ $jurusan->id }}">{{ $jurusan->nama_jurusan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Wali Kelas</label>
                        <select class="form-select" name="wali_kelas" required>
                            <option value="">Pilih Wali Kelas</option>
                            @foreach ($waliKelas as $wali)
                                <option value="{{ $wali->id }}">{{ $wali->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Kelas</label>
                        <input type="text" class="form-control" name="nama_kelas" required maxlength="255">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" form="formTambahKelas" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>

@foreach ($kelas as $kelasItem)
    <div class="modal fade" id="editKelasModal{{ $kelasItem->id }}" tabindex="-1" aria-labelledby="editKelasModalLabel{{ $kelasItem->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editKelasModalLabel{{ $kelasItem->id }}">Edit Kelas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('kelas.update', $kelasItem->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Tingkat</label>
                            <select class="form-select" name="tingkat" required>
                                <option value="X" {{ $kelasItem->tingkat == 'X' ? 'selected' : '' }}>X</option>
                                <option value="XI" {{ $kelasItem->tingkat == 'XI' ? 'selected' : '' }}>XI</option>
                                <option value="XII" {{ $kelasItem->tingkat == 'XII' ? 'selected' : '' }}>XII</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jurusan</label>
                            <select class="form-select" name="jurusan_id" required>
                                <option value="">Pilih Jurusan</option>
                                @foreach ($jurusans as $jurusan)
                                    <option value="{{ $jurusan->id }}" {{ $jurusan->id == $kelasItem->jurusan_id ? 'selected' : '' }}>
                                        {{ $jurusan->nama_jurusan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Wali Kelas</label>
                            <select class="form-select" name="wali_kelas">
                                <option value="">Pilih Wali Kelas</option>
                                @foreach ($waliKelas as $wali)
                                    <option value="{{ $wali->id }}" {{ $wali->id == $kelasItem->wali_kelas ? 'selected' : '' }}>
                                        {{ $wali->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama Kelas</label>
                            <input type="text" class="form-control" name="nama_kelas" value="{{ $kelasItem->nama_kelas }}" required maxlength="255">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

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
    }

    function resetFilter() {
        document.getElementById("filterTingkat").value = "";
        document.getElementById("filterJurusan").value = "";
        document.getElementById("filterWaliKelas").value = "";
        filterKelas();
    }
</script>
@endsection
