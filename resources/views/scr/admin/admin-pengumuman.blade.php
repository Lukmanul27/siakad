@extends('layouts.appadmin')

@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('layouts.sidebar.admin-appsidebar')

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2 text-dark">Pengumuman</h1>
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#tambahPengumumanModal">
                        <i class="fas fa-plus"></i> Buat Pengumuman
                    </button>
                </div>

                <div class="card shadow mb-4">
                    <div class="card-header py-3 bg-primary text-white">
                        <h6 class="m-0 font-weight-bold">Daftar Pengumuman</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
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
                                    @forelse($pengumumans->sortBy('status') as $item)
                                        <tr class="pengumuman-row">
                                            <td class="row-number">{{ $loop->iteration }}</td>
                                            <td>{{ $item->judul }}</td>
                                            <td>{{ $item->tanggal }}</td>
                                            <td>
                                                <span class="badge bg-{{ $item->status === 'aktif' ? 'success' : 'dark' }}">
                                                    {{ $item->status }}
                                                </span>
                                            </td>
                                            <td>
                                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#viewPengumumanModal" data-id="{{ $item->id }}"
                                                    data-judul="{{ $item->judul }}" data-tanggal="{{ $item->tanggal }}"
                                                    data-status="{{ $item->status }}" data-isi="{{ $item->isi }}"
                                                    data-lampiran="{{ $item->lampiran ? asset('storage/' . $item->lampiran) : '' }}">
                                                    Detail
                                                </button>
                                                <form action="{{ route('admin.pengumuman.update', $item->id) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="nonaktif">
                                                    <button type="submit" class="btn btn-warning btn-sm"
                                                        onclick="return confirm('Apakah Anda yakin ingin menonaktifkan pengumuman ini?')">Nonaktifkan</button>
                                                </form>
                                                <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#editPengumumanModal{{ $item->id }}">
                                                    Edit
                                                </button>
                                                <form action="{{ route('admin.pengumuman.destroy', $item->id) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus pengumuman ini?')">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">Tidak ada pengumuman tersedia.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        @include('layouts.modals.admin-pengumuman');
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById('viewPengumumanModal');
        modal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const judul = button.getAttribute('data-judul');
            const tanggal = button.getAttribute('data-tanggal');
            const status = button.getAttribute('data-status');
            const isi = button.getAttribute('data-isi');
            const lampiran = button.getAttribute('data-lampiran');

            this.querySelector('#modalJudul').textContent = judul;
            this.querySelector('#modalTanggal').textContent = tanggal;
            this.querySelector('#modalStatus').textContent = status;
            this.querySelector('#modalIsi').textContent = isi;

            const lampiranLink = this.querySelector('#modalLampiranLink');
            const lampiranFallback = this.querySelector('#modalLampiranFallback');

            if (lampiran) {
                lampiranLink.href = lampiran;
                lampiranLink.style.display = 'inline';
                lampiranFallback.style.display = 'none';
            } else {
                lampiranLink.style.display = 'none';
                lampiranFallback.style.display = 'inline';
            }
        });
    });

    function resetNo() {
        const rows = document.querySelectorAll('#pengumumanTableBody .pengumuman-row');
        let count = 1;
        rows.forEach(row => {
            if (row.style.display !== 'none') {
                row.querySelector('.row-number').textContent = count++;
            } else {
                row.querySelector('.row-number').textContent = '';
            }
        });
    }
</script>
