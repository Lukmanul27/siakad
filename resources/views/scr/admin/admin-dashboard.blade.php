@extends('layouts.appadmin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        @include('layouts.sidebar.admin-appsidebar')

        <!-- Main Content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2 text-dark">Dashboard Admin</h1>
            </div>

            <!-- Statistics Cards -->
            <div class="row">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-3">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Total Guru</div>
                                    <div class="h5 mb-0 font-weight-bold text-dark">{{ \App\Models\User::where('role', 'guru')->count() }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-users fa-2x text-primary"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-3">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Total Siswa</div>
                                    <div class="h5 mb-0 font-weight-bold text-dark">{{ \App\Models\ManajeSiswa::count() }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-user-graduate fa-2x text-success"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-3">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        Mata Pelajaran</div>
                                    <div class="h5 mb-0 font-weight-bold text-dark">{{ \App\Models\Mapel::count() }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-book fa-2x text-info"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-3">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Pengumuman Aktif</div>
                                    <div class="h5 mb-0 font-weight-bold text-dark">5</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-bullhorn fa-2x text-warning"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Aktivitas Terbaru -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card shadow mb-4 border-left-primary">
                        <div class="card-header py-3 bg-primary text-white">
                            <h6 class="m-0 font-weight-bold">Aktivitas Terbaru</h6>
                        </div>
                        <div class="card-body">
                            <div class="list-group">
                                <a href="#" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">Pengumuman baru ditambahkan</h6>
                                        <small class="text-muted">3 hari yang lalu</small>
                                    </div>
                                    <p class="mb-1">Pengumuman mengenai jadwal ujian semester telah dipublikasikan.</p>
                                </a>
                                <a href="#" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">Guru baru terdaftar</h6>
                                        <small class="text-muted">5 hari yang lalu</small>
                                    </div>
                                    <p class="mb-1">2 guru baru telah ditambahkan ke dalam sistem.</p>
                                </a>
                                <a href="#" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">Pembaruan jadwal pelajaran</h6>
                                        <small class="text-muted">1 minggu yang lalu</small>
                                    </div>
                                    <p class="mb-1">Jadwal pelajaran untuk semester baru telah diperbarui.</p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>
@endsection
