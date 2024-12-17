<nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
    <div class="sidebar-sticky">
        <div class="d-flex flex-column align-items-center pt-4 pb-3">
            <h6 class="text-center mb-0 fw-bold">Admin Panel</h6>
            <small class="text-muted">Administrator</small>
        </div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active py-3 px-4" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-home me-2"></i>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link py-3 px-4" href="#">
                    <i class="fas fa-users me-2"></i>
                    Manajemen Guru
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link py-3 px-4" href="#">
                    <i class="fas fa-user-graduate me-2"></i>
                    Manajemen Siswa
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link py-3 px-4" href="#">
                    <i class="fas fa-book me-2"></i>
                    Manajemen Mata Pelajaran
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link py-3 px-4" href="#">
                    <i class="fas fa-calendar-alt me-2"></i>
                    Jadwal Pelajaran
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link py-3 px-4" href="#">
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
            </li>
        </ul>
    </div>
</nav>
