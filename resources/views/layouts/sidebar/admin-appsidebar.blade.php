<nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
    <div class="sidebar-sticky">
        <div class="text-center pt-4 pb-3 border-bottom">
            <h6 class="mb-0 fw-bold text-primary">{{ auth()->user()->name }}</h6>
            <small class="text-muted d-block">{{ auth()->user()->email }}</small>
            <small class="text-muted d-block">{{ auth()->user()->role }}</small>
        </div>
        <ul class="nav flex-column">
            @foreach ([
                ['route' => 'admin.dashboard', 'icon' => 'fas fa-home', 'label' => 'Dashboard'],
                ['route' => 'admin.manajguru', 'icon' => 'fas fa-users', 'label' => 'Manajemen Guru'],
                ['route' => 'admin.manajsiswa', 'icon' => 'fas fa-user-graduate', 'label' => 'Manajemen Siswa'],
                ['route' => 'admin.manajkelas', 'icon' => 'fas fa-school', 'label' => 'Manajemen Kelas'],
                ['route' => 'admin.manajmapel', 'icon' => 'fas fa-book', 'label' => 'Manajemen Mata Pelajaran'],
                ['route' => 'admin.manajjadwal', 'icon' => 'fas fa-calendar-alt', 'label' => 'Jadwal Pelajaran'],
                ['route' => 'admin.pengumuman', 'icon' => 'fas fa-bullhorn', 'label' => 'Pengumuman'],
            ] as $item)
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs($item['route']) ? 'active' : '' }} py-3 px-4" href="{{ route($item['route']) }}">
                        <i class="{{ $item['icon'] }} me-2"></i>
                        {{ $item['label'] }}
                    </a>
                </li>
            @endforeach
            <li class="nav-item">
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
                <a class="nav-link text-danger py-3 px-4" href="{{ route('logout') }}" onclick="event.preventDefault(); if(confirm('Apakah Anda yakin ingin keluar?')) { document.getElementById('logout-form').submit(); }">
                    <i class="fas fa-sign-out-alt me-2"></i>
                    Keluar
                </a>
            </li>
        </ul>
    </div>
</nav>
