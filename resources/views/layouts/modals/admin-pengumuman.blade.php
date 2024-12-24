<!-- Modal View Pengumuman -->
<div class="modal fade" id="viewPengumumanModal" tabindex="-1" aria-labelledby="viewPengumumanLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="viewPengumumanLabel">Detail Pengumuman</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Judul:</strong> <span id="modalJudul"></span></p>
                <p><strong>Tanggal:</strong> <span id="modalTanggal"></span></p>
                <p><strong>Status:</strong> <span id="modalStatus"></span></p>
                <p><strong>Isi:</strong> <span id="modalIsi"></span></p>
                <p><strong>Lampiran:</strong>
                    <a href="{{ asset('storage/' . $item->lampiran) }}" id="modalLampiranLink" target="_blank"
                        style="display:none;">Lihat Lampiran</a>
                    <span id="modalLampiranFallback">Tidak ada lampiran</span>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Pengumuman -->
<div class="modal fade" id="tambahPengumumanModal" tabindex="-1" aria-labelledby="tambahPengumumanModal"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Buat Pengumuman</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.pengumuman.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="judul" class="form-label">Judul</label>
                        <input type="text" class="form-control @error('judul') is-invalid @enderror" id="judul"
                            name="judul" value="{{ old('judul') }}" required>
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                    </div>
                    <div class="mb-3">
                        <label for="isi" class="form-label">Isi</label>
                        <textarea class="form-control" id="isi" name="isi" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="lampiran" class="form-label">Lampiran</label>
                        <input type="file" class="form-control" id="lampiran" name="lampiran"
                            accept=".pdf,.docx,.doc,.jpg,.png,.jpeg">
                    </div>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

@foreach ($pengumumans as $item)
    <!-- Modal Edit Pengumuman -->
    <div class="modal fade" id="editPengumumanModal{{ $item->id }}" tabindex="-1"
        aria-labelledby="editPengumumanLabel{{ $item->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Edit Pengumuman</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.pengumuman.update', $item->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="judul{{ $item->id }}" class="form-label">Judul</label>
                            <input type="text" class="form-control @error('judul') is-invalid @enderror"
                                id="judul{{ $item->id }}" name="judul" value="{{ old('judul', $item->judul) }}"
                                required>
                            @error('judul')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="tanggal{{ $item->id }}" class="form-label">Tanggal</label>
                            <input type="date" class="form-control" id="tanggal{{ $item->id }}"
                                name="tanggal" value="{{ $item->tanggal }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="isi{{ $item->id }}" class="form-label">Isi</label>
                            <textarea class="form-control" id="isi{{ $item->id }}" name="isi" required>{{ $item->isi }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="lampiran{{ $item->id }}" class="form-label">Lampiran</label>
                            <input type="file" class="form-control" id="lampiran{{ $item->id }}"
                                name="lampiran" accept=".pdf,.docx,.doc,.jpg,.png,.jpeg">
                            @if ($item->lampiran)
                                <small class="text-muted">
                                    <a href="{{ asset('storage/' . $item->lampiran) }}" target="_blank">Lihat
                                        Lampiran</a>
                                </small>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach
