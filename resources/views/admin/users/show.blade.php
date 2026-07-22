@extends('layouts.app')
@section('title') Detail User @endsection

@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Detail User</h3>
        <div class="card-tools">
          <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning btn-sm">
            <i class="fas fa-edit"></i> Edit
          </a>
          <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
          </a>
        </div>
      </div>
      <div class="card-body">
        <table class="table table-bordered">
          <tr>
            <th style="width:200px">ID</th>
            <td>{{ $user->id }}</td>
          </tr>
          <tr>
            <th>Nama</th>
            <td>{{ $user->name }}</td>
          </tr>
          <tr>
            <th>Email</th>
            <td>{{ $user->email }}</td>
          </tr>
          <tr>
            <th>Role</th>
            <td>
              @if ($user->role === 'admin')
                <span class="badge badge-danger">Admin</span>
              @else
                <span class="badge badge-success">User</span>
              @endif
            </td>
          </tr>
          <tr>
            <th>Bergabung</th>
            <td>{{ $user->created_at->format('d M Y H:i') }}</td>
          </tr>
          <tr>
            <th>Terakhir Diperbarui</th>
            <td>{{ $user->updated_at->format('d M Y H:i') }}</td>
          </tr>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
