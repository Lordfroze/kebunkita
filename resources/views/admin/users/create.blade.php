@extends('layouts.app')
@section('title') Tambah User @endsection

@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Form Tambah User</h3>
      </div>
      <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf
        <div class="card-body">
          <div class="form-group">
            <label for="name">Nama Lengkap</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
              value="{{ old('name') }}" required>
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
              value="{{ old('email') }}" required>
            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
              name="password" required>
            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="form-group">
            <label for="password_confirmation">Konfirmasi Password</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
          </div>

          <div class="form-group">
            <label for="role">Role</label>
            <select class="form-control @error('role') is-invalid @enderror" id="role" name="role" required>
              <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>User</option>
              <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
            @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>
        </div>

        <div class="card-footer">
          <button type="submit" class="btn btn-primary">Simpan</button>
          <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Batal</a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
