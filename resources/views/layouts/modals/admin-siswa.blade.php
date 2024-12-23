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
                            <select class="form-select" name="jurusan_id" id="tambahJurusan"
                                onchange="updateKelasOptionsTambah()" required>
                                <option value="">Pilih Jurusan</option>
                                @foreach ($jurusans as $jurusan)
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
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success">Simpan</button>
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
                            <select class="form-select" name="jurusan_id" id="editJurusan"
                                onchange="updateKelasOptionsEdit()" required>
                                <option value="">Pilih Jurusan</option>
                                @foreach ($jurusans as $jurusan)
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
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" form="formEditSiswa" class="btn btn-success"
                        onclick="event.preventDefault(); document.getElementById('formEditSiswa').setAttribute('action', '{{ route('admin.siswa.update', 'siswa_id') }}'.replace('siswa_id', document.getElementById('editSiswaId').value)); document.getElementById('formEditSiswa').submit();">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</section>