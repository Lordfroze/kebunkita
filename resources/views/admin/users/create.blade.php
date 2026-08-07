@extends('layouts.app')

@section('title', 'Tambah User')

@section('content')
    <div class="animate-fade-in mx-auto max-w-2xl space-y-5">
        <section class="flex items-center justify-between gap-3">
            <div>
                <h2 class="font-display text-xl font-bold text-slate-800">Tambah User</h2>
                <p class="text-sm text-slate-500">Buat akun pengguna baru untuk sistem KebunKita.</p>
            </div>
            <a href="{{ route('admin.users.index') }}" class="btn-secondary btn-sm">
                <i data-lucide="arrow-left" class="h-4 w-4"></i> Kembali
            </a>
        </section>

        <div class="card p-6">
            <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-4">
                @csrf

                @if (isset($errors) && $errors->any())
                    <div class="flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 p-4">
                        <span class="mt-0.5 text-red-600"><i data-lucide="circle-alert" class="h-5 w-5"></i></span>
                        <ul class="list-inside list-disc text-sm text-red-800">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div>
                    <label for="name" class="form-label">Nama Lengkap</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required class="form-input" placeholder="cth: Budi Santoso">
                </div>

                <div>
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required class="form-input" placeholder="cth: budi@email.com">
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password" required class="form-input" placeholder="Minimal 8 karakter">
                    </div>
                    <div>
                        <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required class="form-input" placeholder="Ulangi password">
                    </div>
                </div>

                <div>
                    <label for="role" class="form-label">Role</label>
                    <select id="role" name="role" required class="form-select">
                        <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>User</option>
                        <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                </div>

                <div class="flex flex-col-reverse gap-2 border-t border-slate-100 pt-4 sm:flex-row sm:justify-end">
                    <a href="{{ route('admin.users.index') }}" class="btn-secondary">Batal</a>
                    <button type="submit" class="btn-primary">
                        <i data-lucide="check" class="h-4 w-4"></i> Simpan User
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
