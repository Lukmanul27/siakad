<!-- Modal Edit User -->
@foreach ($users as $user)
<div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1"
    aria-labelledby="editUserModalLabel{{ $user->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel{{ $user->id }}">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.update.user', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="name" name="name"
                            value="{{ $user->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="nip" class="form-label">NIP</label>
                        <input type="text" class="form-control" id="nip" name="nip"
                            value="{{ $user->nip }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email"
                            value="{{ $user->email }}" required>
                    </div>
                    @if (Auth::user()->role == 'admin')
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select class="form-select" id="role" name="role" required>
                                <option value="admin"
                                    {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="guru"
                                    {{ $user->role == 'guru' ? 'selected' : '' }}>Guru</option>
                            </select>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger"
                        data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach