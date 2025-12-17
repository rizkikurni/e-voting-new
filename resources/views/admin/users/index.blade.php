@extends('admin.layouts.app')

@section('content')
    <main class="page-content">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="mb-0 text-uppercase">Data Users</h6>
            <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm radius-30">
                <i class="bi bi-plus-circle"></i> Tambah User
            </a>
        </div>

        <hr />

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example2" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Trial Dipakai?</th>
                                <th>Dibuat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>

                                    <td>{{ $user->email }}</td>

                                    <td>
                                        <span class="badge
                                            {{ $user->role === 'admin' ? 'bg-primary' : 'bg-success' }}">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>

                                    <td>
                                        @if ($user->is_trial_used)
                                            <span class="badge bg-danger">Sudah</span>
                                        @else
                                            <span class="badge bg-info">Belum</span>
                                        @endif
                                    </td>

                                    <td>{{ $user->created_at->format('d M Y') }}</td>

                                    <td>
                                        <div class="table-actions d-flex align-items-center gap-3 fs-6">

                                            {{-- View (jika ada halaman detail) --}}
                                            <a href="{{ route('users.show', $user->id) }}"
                                                class="text-primary"
                                                data-bs-toggle="tooltip"
                                                data-bs-placement="bottom"
                                                title="View">
                                                <i class="bi bi-eye-fill"></i>
                                            </a>

                                            {{-- Edit --}}
                                            <a href="{{ route('users.edit', $user->id) }}"
                                                class="text-warning"
                                                data-bs-toggle="tooltip"
                                                data-bs-placement="bottom"
                                                title="Edit">
                                                <i class="bi bi-pencil-fill"></i>
                                            </a>

                                            {{-- Delete --}}
                                            <a href="#"
                                                onclick="event.preventDefault(); if(confirm('Yakin hapus user ini?')) document.getElementById('delete-user-{{ $user->id }}').submit();"
                                                class="text-danger"
                                                data-bs-toggle="tooltip"
                                                data-bs-placement="bottom"
                                                title="Delete">
                                                <i class="bi bi-trash-fill"></i>
                                            </a>

                                            <form id="delete-user-{{ $user->id }}"
                                                  action="{{ route('users.destroy', $user->id) }}"
                                                  method="POST"
                                                  hidden>
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
@endsection
