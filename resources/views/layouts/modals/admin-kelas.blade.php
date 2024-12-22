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
