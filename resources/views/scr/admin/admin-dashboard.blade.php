@extends('layouts.appadmin')

@section('title', 'Dashboard')
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
                                    <div class="h5 mb-0 font-weight-bold text-dark">{{ \App\Models\Pengumuman::where('status', 'aktif')->count() }}</div>
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
                                @php
                                    $aktivitas = collect();
                                    $aktivitas = $aktivitas->merge(\App\Models\Jadwal::where('updated_at', '>=', now()->subDays(5))->orderBy('updated_at', 'desc')->take(1)->get());
                                    $aktivitas = $aktivitas->merge(\App\Models\Pengumuman::where('created_at', '>=', now()->subDays(5))->orderBy('created_at', 'desc')->take(3)->get());
                                    $aktivitas = $aktivitas->merge(\App\Models\User::where('role', 'guru')->where('created_at', '>=', now()->subDays(5))->orderBy('created_at', 'desc')->take(2)->get());
                                    $aktivitas = $aktivitas->sortByDesc('created_at');
                                @endphp

                                @foreach ($aktivitas as $item)
                                    @if ($item instanceof \App\Models\Jadwal)
                                        <a href="#" class="list-group-item list-group-item-action bg-light border border-info">
                                            <div class="d-flex w-100 justify-content-between">
                                                <h6 class="mb-1">Pembaruan jadwal pelajaran</h6>
                                                <small class="text-muted">{{ $item->updated_at->diffForHumans() }}</small>
                                            </div>
                                            <p class="mb-1">Jadwal pelajaran untuk semester baru telah diperbarui.</p>
                                        </a>
                                    @elseif ($item instanceof \App\Models\Pengumuman)
                                        <a href="#" class="list-group-item list-group-item-action bg-light border border-info">
                                            <div class="d-flex w-100 justify-content-between">
                                                <h6 class="mb-1">Pengumuman baru ditambahkan: <strong>{{ $item->judul }}</strong></h6>
                                                <small class="text-muted">{{ $item->created_at->diffForHumans() }}</small>
                                            </div>
                                            <p class="mb-1">{{ $item->isi }}</p>
                                        </a>
                                    @elseif ($item instanceof \App\Models\User)
                                        <a href="#" class="list-group-item list-group-item-action bg-light border border-info">
                                            <div class="d-flex w-100 justify-content-between">
                                                <h6 class="mb-1">Guru baru terdaftar: <strong>{{ $item->name }}</strong></h6>
                                                <small class="text-muted">{{ $item->created_at->diffForHumans() }}</small>
                                            </div>
                                        </a>
                                    @endif
                                    <div class="dropdown-divider"></div>
                                @endforeach
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
