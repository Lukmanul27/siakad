@extends('layouts.appadmin')

@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('layouts.sidebar.admin-appsidebar')

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Manajemen Guru & Admin</h1>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahUser">
                        <i class="fas fa-plus"></i> Tambah User
                    </button>
                </div>

                @foreach (['admin' => 'Admin', 'guru' => 'Guru'] as $role => $title)
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Daftar {{ $title }}</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable{{ $title }}">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>NIP</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $users = \App\Models\User::where('role', $role)->get(); @endphp

                                        @forelse($users as $index => $user)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->nip }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->role }}</td>
                                                <td>
                                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                                        data-bs-target="#editUserModal{{ $user->id }}">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <form action="{{ route('admin.delete.user', $user->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">Tidak ada data
                                                    {{ strtolower($title) }}</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @include('layouts.modals.user-edit')
                @endforeach
            </main>
        </div>
    </div>

    @include('layouts.modals.user-create')
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#dataTableGuru, #dataTableAdmin').DataTable();

            @if (session('success'))
                alert("{{ session('success') }}");
            @endif

            @if (session('error'))
                alert("{{ session('error') }}");
            @endif
        });
    </script>
@endsection
