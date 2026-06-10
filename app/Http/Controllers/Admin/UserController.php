<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
  public function __construct()
  {
    // Hanya super-admin yang bisa mengakses manajemen user
    $this->middleware('role:super-admin');
    $this->middleware('permission:manage users');
  }

  public function index()
  {
    $users = User::with('roles')->latest()->paginate(15);
    return view('admin.users.index', compact('users'));
  }

  public function create()
  {
    // Hanya bisa membuat user dengan role staff-admin atau public
    $roles = Role::whereIn('name', ['staff-admin', 'public'])->get();
    return view('admin.users.create', compact('roles'));
  }

  public function store(Request $request)
  {
    $validated = $request->validate([
      'name' => ['required', 'string', 'max:255'],
      'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
      'password' => ['required', 'confirmed', Rules\Password::defaults()],
      'role' => ['required', 'string', 'in:staff-admin,public'],
    ]);

    $user = User::create([
      'name' => $validated['name'],
      'email' => strtolower($validated['email']),
      'password' => Hash::make($validated['password']),
    ]);

    $user->assignRole($validated['role']);

    return redirect()->route('admin.users.index')
      ->with('success', 'User berhasil dibuat!');
  }

  public function show(User $user)
  {
    $user->load('roles');
    return view('admin.users.show', compact('user'));
  }

  public function edit(User $user)
  {
    // Tidak bisa edit super-admin
    if ($user->hasRole('super-admin')) {
      return redirect()->route('admin.users.index')
        ->with('error', 'Tidak dapat mengedit akun Super Admin!');
    }

    $roles = Role::whereIn('name', ['staff-admin', 'public'])->get();
    return view('admin.users.edit', compact('user', 'roles'));
  }

  public function update(Request $request, User $user)
  {
    // Tidak bisa update super-admin
    if ($user->hasRole('super-admin')) {
      return redirect()->route('admin.users.index')
        ->with('error', 'Tidak dapat mengubah akun Super Admin!');
    }

    $validated = $request->validate([
      'name' => ['required', 'string', 'max:255'],
      'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
      'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
      'role' => ['required', 'string', 'in:staff-admin,public'],
    ]);

    $user->name = $validated['name'];
    $user->email = strtolower($validated['email']);

    if (!empty($validated['password'])) {
      $user->password = Hash::make($validated['password']);
    }

    $user->save();
    $user->syncRoles([$validated['role']]);

    return redirect()->route('admin.users.index')
      ->with('success', 'User berhasil diupdate!');
  }

  public function destroy(User $user)
  {
    // Tidak bisa hapus super-admin atau diri sendiri
    if ($user->hasRole('super-admin')) {
      return redirect()->route('admin.users.index')
        ->with('error', 'Tidak dapat menghapus akun Super Admin!');
    }

    if ($user->id === auth()->id()) {
      return redirect()->route('admin.users.index')
        ->with('error', 'Tidak dapat menghapus akun sendiri!');
    }

    $user->delete();

    return redirect()->route('admin.users.index')
      ->with('success', 'User berhasil dihapus!');
  }
}
