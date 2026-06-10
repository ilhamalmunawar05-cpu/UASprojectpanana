@extends('layouts.app')

@section('page-title', 'Detail User')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Detail User</h5>
                @if(!$user->hasRole('super-admin'))
                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-warning">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                @endif
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="200">Nama:</th>
                        <td>{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <th>Email:</th>
                        <td>{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <th>Role:</th>
                        <td>
                            @foreach($user->roles as $role)
                                @if($role->name === 'super-admin')
                                    <span class="badge bg-danger">{{ ucwords(str_replace('-', ' ', $role->name)) }}</span>
                                @elseif($role->name === 'staff-admin')
                                    <span class="badge bg-warning">{{ ucwords(str_replace('-', ' ', $role->name)) }}</span>
                                @else
                                    <span class="badge bg-info">{{ ucwords(str_replace('-', ' ', $role->name)) }}</span>
                                @endif
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>Tanggal Dibuat:</th>
                        <td>{{ $user->created_at->format('d F Y, H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Terakhir Diupdate:</th>
                        <td>{{ $user->updated_at->format('d F Y, H:i') }}</td>
                    </tr>
                </table>

                <div class="mt-4">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    @if(!$user->hasRole('super-admin') && $user->id !== auth()->id())
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash"></i> Hapus User
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card bg-light">
            <div class="card-body">
                <h6 class="card-title"><i class="fas fa-shield-alt"></i> Permissions</h6>
                @if($user->roles->isNotEmpty())
                    @php
                        $role = $user->roles->first();
                        $permissions = $role->permissions;
                    @endphp
                    @if($permissions->isNotEmpty())
                        <ul class="small">
                            @foreach($permissions as $permission)
                                <li>{{ ucwords($permission->name) }}</li>
                            @endforeach
                        </ul>
                    @else
                        <p class="small text-muted">Tidak ada permission khusus</p>
                    @endif
                @else
                    <p class="small text-muted">User belum memiliki role</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
