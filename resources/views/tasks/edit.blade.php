@extends('layouts.app')

@section('title', 'Feladat szerkesztése')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">

        <h2 class="mb-3">Feladat szerkesztése</h2>

        <form method="POST" action="{{ route('tasks.update', $task) }}">
            @csrf
            @method('PUT')

            <x-input name="title" />

            <x-textarea name="description" />


            <x-button>Frissítés</x-button>
            <a href="{{ route('tasks.index') }}" class="btn btn-secondary">
                Mégse
            </a>

        </form>

    </div>
</div>
@endsection
