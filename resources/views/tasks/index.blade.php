@extends('layouts.app')

@section('title', 'Feladatok listázása')

@section('content')

    <div class="row">
        <div class="col-md-6">
            <h2 class="mb-3">
                Új Feladat
            </h2>

            <form action="{{ route('tasks.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Cím</label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                        value="{{ old('title') }}">

                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Leírás</label>
                    <textarea name="description" class="form-control">{{ old('description') }}</textarea>
                </div>

                <button class="btn btn-primary">Mentés</button>
            </form>
        </div>

        <div class="col-md-6">
            <h2 class="mb-3">Feladatlista</h2>

            @forelse ($tasks as $task)
                <div class="card mb-2 {{ $task->is_completed ? 'opacity-50' : '' }}">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <strong
                                class="{{ $task->is_completed ? 'text-decoration-line-throught' : '' }}">{{ $task->title }}</strong>
                            @if ($task->description)
                                <div class="text-muted small">
                                    {{ $task->description }}
                                </div>
                            @endif
                        </div>

                        <div class="d-flex gap-2">
                            <form method="POST" action="{{ route('tasks.toggle', $task) }}">
                                @method('PUT')
                                @csrf

                                <button class="btn btn-sm btn-outline-success">
                                    {{ $task->is_completed ? 'Visszaállít' : 'Kész' }}
                                </button>
                            </form>
                            <form method="POST" action="{{ route('tasks.destroy', $task) }}"
                                onsubmit="return confirm('Biztosan törölni akarod?')">

                                <a href="{{ route('tasks.edit', $task) }}"
                                    class="btn btn-sm btn-outline-primary">Szerkesztés</a>


                                @csrf
                                @method('DELETE')

                                <button class="btn btn-sm btn-outline-danger">Törlés</button>

                            </form>
                        </div>


                    </div>
                </div>

            @empty
                <p class="text-muted">Nincs még feladat!</p>
            @endforelse

            {{-- Pagination --}}
            @if ($tasks->hasPages())
                <div class="mt-3">
                    {{ $tasks->links('pagination::bootstrap-5') }}
                </div>
            @endif



        </div>
    </div>

@endsection
