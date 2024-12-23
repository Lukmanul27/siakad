@extends('layouts.appadmin')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            @include('layouts.sidebar.admin-appsidebar')

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2 text-dark">Pengumuman</h1>
                </div>

                <!-- Daftar Pengumuman -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3 bg-primary text-white">
                        <h6 class="m-0 font-weight-bold">Daftar Pengumuman</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Judul</th>
                                        <th>Tanggal</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="pengumumanTableBody">
                                    <tr data-bs-toggle="modal" data-bs-target="#viewPengumumanModal"
                                        data-judul="Jadwal Ujian Semester Ganjil" data-tanggal="2023-12-01"
                                        data-status="aktif"
                                        data-isi="Jadwal ujian semester ganjil akan dilaksanakan pada tanggal yang telah ditentukan."
                                        data-lampiran="ujian_semester_ganjil.pdf">
                                        <td>1</td>
                                        <td>Jadwal Ujian Semester Ganjil</td>
                                        <td>2023-12-01</td>
                                        <td><span class="badge bg-success">aktif</span></td>
                                        <td>
                                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editPengumumanModal1">Edit</button>
                                            <button class="btn btn-danger btn-sm" onclick="confirmDelete(1)">Hapus</button>
                                        </td>
                                    </tr>
                                    <tr data-bs-toggle="modal" data-bs-target="#viewPengumumanModal"
                                        data-judul="Rapat Guru dan Staff" data-tanggal="2023-12-05" data-status="aktif"
                                        data-isi="Rapat guru dan staff akan membahas agenda penting." data-lampiran="">
                                        <td>2</td>
                                        <td>Rapat Guru dan Staff</td>
                                        <td>2023-12-05</td>
                                        <td><span class="badge bg-success">aktif</span></td>
                                        <td>
                                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editPengumumanModal2">Edit</button>
                                            <button class="btn btn-danger btn-sm" onclick="confirmDelete(2)">Hapus</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Modal View Pengumuman -->
    <div class="modal fade" id="viewPengumumanModal" tabindex="-1" aria-labelledby="viewPengumumanLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="viewPengumumanLabel">Detail Pengumuman</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Judul:</strong> <span id="modalJudul"></span></p>
                    <p><strong>Tanggal:</strong> <span id="modalTanggal"></span></p>
                    <p><strong>Status:</strong> <span id="modalStatus"></span></p>
                    <p><strong>Isi:</strong> <span id="modalIsi"></span></p>
                    <p><strong>Lampiran:</strong> <span id="modalLampiran"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Pengumuman -->
    <div class="modal fade" id="editPengumumanModal1" tabindex="-1" aria-labelledby="editPengumumanLabel1"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title" id="editPengumumanLabel1">Edit Pengumuman</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="judul" class="form-label">Judul</label>
                            <input type="text" class="form-control" id="judul" name="judul"
                                value="Jadwal Ujian Semester Ganjil" required>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal" value="2023-12-01"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="isi" class="form-label">Isi</label>
                            <textarea class="form-control" id="isi" name="isi" required>Jadwal ujian semester ganjil akan dilaksanakan pada tanggal yang telah ditentukan.</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="lampiran" class="form-label">Lampiran</label>
                            <input type="file" class="form-control" id="lampiran" name="lampiran">
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editPengumumanModal2" tabindex="-1" aria-labelledby="editPengumumanLabel2"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title" id="editPengumumanLabel2">Edit Pengumuman</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="judul" class="form-label">Judul</label>
                            <input type="text" class="form-control" id="judul" name="judul"
                                value="Rapat Guru dan Staff" required>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal" value="2023-12-05"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="isi" class="form-label">Isi</label>
                            <textarea class="form-control" id="isi" name="isi" required>Rapat guru dan staff akan membahas agenda penting.</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="lampiran" class="form-label">Lampiran</label>
                            <input type="file" class="form-control" id="lampiran" name="lampiran">
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function confirmDelete(id) {
            if (confirm('Apakah Anda yakin ingin menghapus pengumuman ini?')) {
                console.log('Pengumuman dengan ID ' + id + ' dihapus.');
            }
        }

        $(document).ready(function() {
            $('#dataTable').DataTable();

            $('#pengumumanTableBody').on('click', 'tr', function() {
                var judul = $(this).data('judul');
                var tanggal = $(this).data('tanggal');
                var status = $(this).data('status');
                var isi = $(this).data('isi');
                var lampiran = $(this).data('lampiran');

                $('#modalJudul').text(judul);
                $('#modalTanggal').text(tanggal);
                $('#modalStatus').text(status);
                $('#modalIsi').text(isi);
                $('#modalLampiran').text(lampiran ? lampiran : 'Tidak ada lampiran');
            });
        });
    </script>
@endsection
