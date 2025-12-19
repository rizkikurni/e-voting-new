@extends('admin.layouts.app')

@section('content')
<main class="page-content">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h6 class="mb-0 text-uppercase">Kandidat Event</h6>
            <small class="text-muted">{{ $event->title }}</small>
        </div>

        @if ($event->isEditable())
            <a href="{{ route('events.candidates.create', $event->id) }}"
               class="btn btn-primary btn-sm radius-30">
                <i class="bi bi-plus-circle"></i> Tambah Kandidat
            </a>
        @endif
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr class="text-center">
                            <th>Nama</th>
                            <th>Deskripsi</th>
                            <th>Vote</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($candidates as $candidate)
                            <tr>
                                <td>{{ $candidate->name }}</td>
                                <td>{{ $candidate->description ?? '-' }}</td>
                                <td class="text-center">{{ $candidate->votes_count }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">

                                        <a href="{{ route('events.candidates.show', [$event->id, $candidate->id]) }}"
                                           class="btn btn-outline-primary btn-sm">
                                            <i class="bi bi-eye-fill"></i>
                                        </a>

                                        @if ($event->isEditable())
                                            <a href="{{ route('events.candidates.edit', [$event->id, $candidate->id]) }}"
                                               class="btn btn-outline-warning btn-sm">
                                                <i class="bi bi-pencil-fill"></i>
                                            </a>

                                            <form action="{{ route('events.candidates.destroy', [$event->id, $candidate->id]) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Hapus kandidat ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-outline-danger btn-sm">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </form>
                                        @endif

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <a href="{{ route('events.index') }}" class="btn btn-secondary btn-sm mt-3">
                <i class="bi bi-arrow-left"></i> Kembali ke Event
            </a>
        </div>
    </div>

</main>
@endsection
