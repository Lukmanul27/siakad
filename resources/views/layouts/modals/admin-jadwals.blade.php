<!-- Modal Tambah Jadwal -->
<div class="modal fade" id="tambahJadwalModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Tambah Jadwal Pelajaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formTambahJadwal" action="{{ route('admin.jadwal.store') }}" method="POST">
                    @csrf

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label">Hari</label>
                        <select class="form-select" name="hari" required>
                            <option value="">Pilih Hari</option>
                            @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $hari)
                                <option value="{{ $hari }}">{{ $hari }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jurusan</label>
                        <select class="form-select" id="jurusanSelect" name="jurusan_id" required
                            onchange="toggleFields()">
                            <option value="">Pilih Jurusan</option>
                            <option value="0">Seluruh Jurusan</option>
                            @foreach ($jurusans as $jurusan)
                                <option value="{{ $jurusan->id }}">{{ $jurusan->nama_jurusan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3" id="kelasContainer" style="display: none;">
                        <label class="form-label">Kelas</label>
                        <select class="form-select" id="kelasSelect" name="kelas_id" required>
                            <option value="">Pilih Kelas</option>
                            @foreach ($kelas as $k)
                                <option value="{{ $k->id }}" data-jurusan="{{ $k->jurusan_id }}">
                                    {{ $k->nama_kelas }}</option>
                            @endforeach
                            <option value="95">Seluruh Kelas</option>
                        </select>
                    </div>
                    <div class="mb-3" id="jamKeContainer" style="display: none;">
                        <label class="form-label">Jam Ke</label>
                        <select class="form-select" name="jam_ke" required>
                            <option value="">Pilih Jam</option>
                            @for ($i = 1; $i <= 10; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="mb-3" id="waktuContainer" style="display: none;">
                        <label class="form-label">Waktu</label>
                        <input type="text" class="form-control" name="waktu" value="{{ old('waktu') }}"
                            placeholder="Contoh: 08:00 - 10:00" required />
                        <small class="form-text text-muted">Masukkan waktu dalam format jam (HH:MM) untuk menentukan
                            waktu mulai dan selesai.</small>
                    </div>
                    <div class="mb-3" id="mataPelajaranContainer" style="display: none;">
                        <label class="form-label">Mata Pelajaran</label>
                        <select class="form-select" id="mataPelajaranSelect" name="mata_pelajaran_id" required>
                            <option value="">Pilih Mata Pelajaran</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Guru Pengajar</label>
                        <select class="form-select" id="guruSelect" name="guru_id" required>
                            <option value="">Pilih Guru</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ruangan</label>
                        <input type="text" class="form-control" name="ruangan" value="{{ old('ruangan') }}" />
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" id="resetForm">Reset</button>
                <button type="submit" form="formTambahJadwal" class="btn btn-success">Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Jadwal -->
@foreach ($jadwals as $jadwal)
    <div class="modal fade" id="editJadwalModal{{ $jadwal->id }}" tabindex="-1"
        aria-labelledby="editJadwalLabel{{ $jadwal->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="editJadwalLabel{{ $jadwal->id }}">Edit Jadwal Pelajaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formEditJadwal{{ $jadwal->id }}"
                        action="{{ route('admin.jadwal.update', $jadwal->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Hari</label>
                            <select class="form-select" name="hari" required>
                                @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $hari)
                                    <option value="{{ $hari }}"
                                        {{ $jadwal->hari == $hari ? 'selected' : '' }}>{{ $hari }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Jurusan</label>
                            <select class="form-select" name="jurusan_id" required>
                                <option value="0" {{ $jadwal->jurusan_id == 0 ? 'selected' : '' }}>Seluruh
                                    Jurusan</option>
                                @foreach ($jurusans as $jurusan)
                                    <option value="{{ $jurusan->id }}"
                                        {{ $jadwal->jurusan_id == $jurusan->id ? 'selected' : '' }}>
                                        {{ $jurusan->nama_jurusan }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kelas</label>
                            <select class="form-select" name="kelas_id" required>
                                <option value="95" {{ $jadwal->kelas_id == 95 ? 'selected' : '' }}>Seluruh Kelas
                                </option>
                                @foreach ($kelas as $k)
                                    <option value="{{ $k->id }}"
                                        {{ $jadwal->kelas_id == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Jam Ke</label>
                            <select class="form-select" name="jam_ke" required>
                                @for ($i = 1; $i <= 10; $i++)
                                    <option value="{{ $i }}"
                                        {{ $jadwal->jam_ke == $i ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Waktu</label>
                            <input type="time" class="form-control" name="waktu" value="{{ $jadwal->waktu }}"
                                required />
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Mata Pelajaran</label>
                            <select class="form-select" name="mata_pelajaran_id" required>
                                <option value="90" {{ $jadwal->mata_pelajaran_id == 90 ? 'selected' : '' }}>
                                    Upacara</option>
                                <option value="91" {{ $jadwal->mata_pelajaran_id == 91 ? 'selected' : '' }}>
                                    Istirahat</option>
                                <option value="92" {{ $jadwal->mata_pelajaran_id == 92 ? 'selected' : '' }}>Apel
                                </option>
                                @foreach ($mapels as $mapel)
                                    <option value="{{ $mapel->id }}"
                                        {{ $jadwal->mata_pelajaran_id == $mapel->id ? 'selected' : '' }}>
                                        {{ $mapel->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Guru Pengajar</label>
                            <select class="form-select" name="guru_id" required>
                                <option value="93" {{ $jadwal->guru_id == 93 ? 'selected' : '' }}>Semua Guru
                                </option>
                                <option value="94" {{ $jadwal->guru_id == 94 ? 'selected' : '' }}> - </option>
                                @foreach ($gurus as $guru)
                                    <option value="{{ $guru->id }}"
                                        {{ $jadwal->guru_id == $guru->id ? 'selected' : '' }}>{{ $guru->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Ruangan</label>
                            <input type="text" class="form-control" name="ruangan"
                                value="{{ $jadwal->ruangan ?? 'Belum Ditentukan' }}" />
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" form="formEditJadwal{{ $jadwal->id }}"
                        class="btn btn-success">Simpan</button>
                </div>
            </div>
        </div>
    </div>
@endforeach