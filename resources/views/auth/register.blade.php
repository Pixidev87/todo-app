@extends('layouts.app')

@section('title', 'Regisztráció')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">

        <div class="card shadow-sm">
            <div class="card-body">
                <h4 class="card-title mb-4 text-center">
                    Regisztráció
                </h4>

                <form method="POST" action="{{ route('auth.register') }}">
                    @csrf

                    {{-- Név --}}
                    <div class="mb-3">
                        <label class="form-label">Név</label>
                        <input
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            class="form-control @error('name') is-invalid @enderror"
                        >

                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

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
                    <div class="mb-3">
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

                    {{-- Jelszó megerősítés --}}
                    <div class="mb-4">
                        <label class="form-label">Jelszó újra</label>
                        <input
                            type="password"
                            name="password_confirmation"
                            class="form-control"
                        >
                    </div>

                    <div class="d-grid">
                        <button class="btn btn-primary">
                            Regisztráció
                        </button>
                    </div>
                </form>

                <div class="text-center mt-3">
                    <small>
                        Már van fiókod?
                        <a href="{{ route('auth.login') }}">
                            Bejelentkezés
                        </a>
                    </small>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

