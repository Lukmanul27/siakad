<nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
    <div class="sidebar-sticky">
        <div class="d-flex flex-column align-items-center pt-4 pb-3">
            <h6 class="text-center mb-0 fw-bold">{{ Auth::user()->name }}</h6>
            <small class="text-muted">{{ Auth::user()->email }}</small>
            <small class="text-muted">{{ Auth::user()->role }}</small>
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
                <a class="nav-link text-danger py-3 px-4" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt me-2"></i>
                    Keluar
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
</nav>
