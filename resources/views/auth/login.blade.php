@extends('layouts.app')

@section('title', 'Bejelentkezés')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">

        <div class="card shadow-sm">
            <div class="card-body">
                <h4 class="card-title mb-4 text-center">
                    Bejelentkezés
                </h4>

                <form method="POST" action="{{ route('auth.login') }}">
                    @csrf

                    {{-- Email --}}
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            class="form-control @error('email') is-invalid @enderror"
                        >

                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Jelszó --}}
                    <div class="mb-4">
                        <label class="form-label">Jelszó</label>
                        <input
                            type="password"
                            name="password"
                            class="form-control @error('password') is-invalid @enderror"
                        >

                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="d-grid">
                        <button class="btn btn-primary">
                            Bejelentkezés
                        </button>
                    </div>
                </form>

                <div class="text-center mt-3">
                    <small>
                        Nincs még fiókod?
                        <a href="{{ route('auth.register') }}">
                            Regisztráció
                        </a>
                    </small>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
