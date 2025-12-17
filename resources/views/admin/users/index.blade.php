@extends('admin.layouts.app')

@section('content')
    <main class="page-content">

        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h6 class="mb-0 text-uppercase fw-bold">Data Users</h6>
                <small class="text-muted">Manajemen data admin & customer</small>
            </div>

            <a href="{{ route('users.create') }}"
                class="btn btn-primary btn-sm px-4 radius-30 d-flex align-items-center gap-2">
                <i class="bi bi-plus-circle"></i>
                Tambah User
            </a>
        </div>

        {{-- FILTER ROLE --}}
        <div class="mb-3 d-flex gap-2">
            <button class="btn btn-outline-secondary btn-sm filter-btn active" data-role="all">
                <i class="bi bi-people"></i> Semua
            </button>
            <button class="btn btn-outline-primary btn-sm filter-btn" data-role="admin">
                <i class="bi bi-shield-lock"></i> Admin
            </button>
            <button class="btn btn-outline-success btn-sm filter-btn" data-role="customer">
                <i class="bi bi-person"></i> Customer
            </button>
        </div>

        <div class="card">
            <div class="card-body">

                <div class="table-responsive">
                    <table id="example2" class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr class="text-center">
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Trial</th>
                                <th>Dibuat</th>
                                <th width="150">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($users as $user)
                                <tr data-role="{{ $user->role }}">
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>

                                    <td class="text-center">
                                        <span
                                            class="badge rounded-pill
                                    {{ $user->role === 'admin' ? 'bg-primary' : 'bg-success' }}">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>

                                    <td class="text-center">
                                        @if ($user->is_trial_used)
                                            <span class="badge bg-danger">Sudah</span>
                                        @else
                                            <span class="badge bg-info">Belum</span>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        {{ $user->created_at->format('d M Y') }}
                                    </td>

                                    {{-- AKSI --}}
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">

                                            {{-- VIEW --}}
                                            <a href="{{ route('users.show', $user->id) }}"
                                                class="btn btn-outline-primary btn-sm action-btn" data-bs-toggle="tooltip"
                                                title="Detail">
                                                <i class="bi bi-eye-fill"></i>
                                            </a>

                                            {{-- EDIT --}}
                                            <a href="{{ route('users.edit', $user->id) }}"
                                                class="btn btn-outline-warning btn-sm action-btn" data-bs-toggle="tooltip"
                                                title="Edit">
                                                <i class="bi bi-pencil-fill"></i>
                                            </a>

                                            {{-- DELETE --}}
                                            <button class="btn btn-outline-danger btn-sm action-btn"
                                                data-bs-toggle="tooltip" title="Hapus"
                                                onclick="event.preventDefault();
                                            if(confirm('Yakin hapus user ini?'))
                                            document.getElementById('delete-user-{{ $user->id }}').submit();">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>

                                            <form id="delete-user-{{ $user->id }}"
                                                action="{{ route('users.destroy', $user->id) }}" method="POST" hidden>
                                                @csrf
                                                @method('DELETE')
                                            </form>

                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>

            </div>
        </div>

    </main>

    {{-- FILTER ROLE SCRIPT --}}
    <script>
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.addEventListener('click', function() {

                document.querySelectorAll('.filter-btn')
                    .forEach(b => b.classList.remove('active'));

                this.classList.add('active');

                const role = this.dataset.role;

                document.querySelectorAll('tbody tr').forEach(row => {
                    if (role === 'all' || row.dataset.role === role) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        });
    </script>
@endsection
