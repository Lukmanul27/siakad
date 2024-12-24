@extends('layouts.appguru')

@section('title', 'Pengumuman')
@section('content')
<div class="container-fluid">
    <div class="row">
        @include('layouts.sidebar.guru-appsidebar')
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Pengumuman</h1>
            </div>

            <!-- Daftar Pengumuman -->
            <div class="row">
                <div class="col-12">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">Daftar Pengumuman</h6>
                        </div>
                        <div class="card-body">
                            <div class="list-group" id="pengumumanList">
                                <!-- Data pengumuman akan diisi oleh JavaScript -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<style>
.cursor-pointer {
    cursor: pointer;
}
.preview-text {
    color: #666;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>

<script>
// Data dummy pengumuman
const pengumumanData = [
    {
        id: 1,
        judul: "Rapat Guru Semester Genap",
        tanggal: "3 hari yang lalu",
        previewText: "Rapat koordinasi guru akan dilaksanakan pada hari Jumat...",
        isiLengkap: `
            <p>Rapat koordinasi guru akan dilaksanakan pada hari Jumat, 20 Januari 2024 pukul 09.00 WIB di Aula Sekolah. Agenda rapat meliputi:</p>
            <ul>
                <li>Evaluasi pembelajaran semester ganjil</li>
                <li>Persiapan pembelajaran semester genap</li>
                <li>Pembahasan program sekolah</li>
            </ul>
            <p>Mohon kehadiran Bapak/Ibu guru tepat waktu.</p>
        `
    },
    {
        id: 2,
        judul: "Pengumpulan Nilai UTS",
        tanggal: "5 hari yang lalu",
        previewText: "Batas waktu pengumpulan nilai UTS adalah minggu depan...",
        isiLengkap: `
            <p>Diberitahukan kepada seluruh guru mata pelajaran untuk segera mengumpulkan nilai UTS semester genap paling lambat:</p>
            <p><strong>Hari/Tanggal: Senin, 23 Januari 2024</strong></p>
            <p>Nilai dikumpulkan dalam format excel yang telah disediakan dan dikirim ke email kurikulum@sekolah.com</p>
        `
    },
    {
        id: 3,
        judul: "Pelatihan Pengembangan Kompetensi Guru",
        tanggal: "1 minggu yang lalu",
        previewText: "Akan diadakan pelatihan pengembangan kompetensi guru...",
        isiLengkap: `
            <p>Dalam rangka meningkatkan kompetensi guru, akan diadakan pelatihan dengan rincian:</p>
            <ul>
                <li>Tanggal: 25-26 Januari 2024</li>
                <li>Tempat: Ruang Multimedia</li>
                <li>Waktu: 08.00 - 15.00 WIB</li>
                <li>Tema: Implementasi Teknologi dalam Pembelajaran</li>
            </ul>
            <p>Mohon konfirmasi kehadiran melalui grup WhatsApp.</p>
        `
    }
];

// Function untuk menampilkan pengumuman
function renderPengumuman() {
    const pengumumanList = document.getElementById('pengumumanList');
    pengumumanList.innerHTML = '';

    pengumumanData.forEach(pengumuman => {
        pengumumanList.innerHTML += `
            <div class="list-group-item list-group-item-action cursor-pointer mb-3" onclick="togglePengumuman('pengumuman${pengumuman.id}')">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">${pengumuman.judul}</h5>
                    <small class="text-muted">${pengumuman.tanggal}</small>
                </div>
                <p class="mb-1 preview-text">${pengumuman.previewText}</p>
                <div class="collapse" id="pengumuman${pengumuman.id}">
                    <div class="mt-3">
                        ${pengumuman.isiLengkap}
                    </div>
                </div>
            </div>
        `;
    });
}

// Function untuk toggle pengumuman
function togglePengumuman(id) {
    const element = document.getElementById(id);
    if (element) {
        element.classList.toggle('show');
    }
}

// Load pengumuman saat halaman dimuat
document.addEventListener('DOMContentLoaded', function() {
    renderPengumuman();
});
</script>
@endsection

