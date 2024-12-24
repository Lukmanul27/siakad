<nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
    <div class="sidebar-sticky">
        <div class="text-center pt-4 pb-3 border-bottom">
            <h6 class="mb-0 fw-bold text-primary">{{ auth()->user()->name }}</h6>
            <small class="text-muted d-block">{{ auth()->user()->email }}</small>
            <small class="text-muted d-block">{{ auth()->user()->role }}</small>
        </div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('guru.dashboard') ? 'active' : '' }} py-3 px-4" href="{{ route('guru.dashboard') }}">
                    <i class="fas fa-home me-2"></i>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('guru.jadwal') ? 'active' : '' }} py-3 px-4" href="{{ route('guru.jadwal') }}">
                    <i class="fas fa-calendar-alt me-2"></i>
                    Jadwal Mengajar
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('guru.absensi') ? 'active' : '' }} py-3 px-4" href="{{ route('guru.absensi') }}">
                    <i class="fas fa-user-check me-2"></i>
                    Absensi Siswa
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('guru.nilai') ? 'active' : '' }} py-3 px-4" href="{{ route('guru.nilai') }}">
                    <i class="fas fa-chart-bar me-2"></i>
                    Nilai
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('guru.pengumuman') ? 'active' : '' }} py-3 px-4" href="{{ route('guru.pengumuman') }}">
                    <i class="fas fa-bullhorn me-2"></i>
                    Pengumuman
                </a>
            </li>
            <li class="nav-item">
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
                <a class="nav-link text-danger py-3 px-4" href="{{ route('logout') }}"
                    onclick="event.preventDefault(); if(confirm('Apakah Anda yakin ingin keluar?')) { document.getElementById('logout-form').submit(); }">
                    <i class="fas fa-sign-out-alt me-2"></i>
                    Keluar
                </a>
            </li>
        </ul>
    </div>
</nav>
