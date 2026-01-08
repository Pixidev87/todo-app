@extends('layouts.app')

@section('title', 'Feladat szerkesztése')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">

        <h2 class="mb-3">Feladat szerkesztése</h2>

        <form method="POST" action="{{ route('tasks.update', $task) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Cím</label>
                <input
                    type="text"
                    name="title"
                    class="form-control @error('title') is-invalid @enderror"
                    value="{{ old('title', $task->title) }}"
                >

                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Leírás</label>
                <textarea
                    name="description"
                    class="form-control"
                >{{ old('description', $task->description) }}</textarea>
            </div>

            <button class="btn btn-primary">Mentés</button>
            <a href="{{ route('tasks.index') }}" class="btn btn-secondary">
                Mégse
            </a>

        </form>

    </div>
</div>
@endsection
