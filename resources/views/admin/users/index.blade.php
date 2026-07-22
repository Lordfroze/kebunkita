@extends('layouts.app')
@section('title') Manajemen User @endsection

@section('content')
<div class="content">
  <div class="container-fluid">
    @if (session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    @endif

    @if (session('error'))
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    @endif

    <div class="card">
      <div class="card-header d-flex align-items-center">
        <h3 class="card-title">Daftar User</h3>
        <div class="ml-auto">
          <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Tambah User
          </a>
        </div>
      </div>
      <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
          <thead>
            <tr>
              <th>#</th>
              <th>Nama</th>
              <th>Email</th>
              <th>Role</th>
              <th>Bergabung</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($users as $user)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $user->name }}</td>
              <td>{{ $user->email }}</td>
              <td>
                @if ($user->role === 'admin')
                  <span class="badge badge-danger">Admin</span>
                @else
                  <span class="badge badge-success">User</span>
                @endif
              </td>
              <td>{{ $user->created_at->format('d M Y') }}</td>
              <td>
                <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-info btn-sm">
                  <i class="fas fa-eye"></i>
                </a>
                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning btn-sm">
                  <i class="fas fa-edit"></i>
                </a>
                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline"
                  onsubmit="return confirm('Yakin ingin menghapus user {{ $user->name }}?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger btn-sm">
                    <i class="fas fa-trash"></i>
                  </button>
                </form>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="6" class="text-center">Tidak ada data user.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      @if ($users->hasPages())
      <div class="card-footer clearfix">
        <div class="float-right">
          {{ $users->links() }}
        </div>
      </div>
      @endif
    </div>
  </div>
</div>
@endsection
