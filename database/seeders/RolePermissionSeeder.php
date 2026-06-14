<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Buat Permissions untuk modul galeri dan perpustakaan
        $permissions = [
            'manage artworks',
            'manage artists',
            'manage exhibitions',
            'manage auctions',
            'manage articles',
            'manage comments',
            'manage collections',
            'manage users',
            'manage books',
            'manage members',
            'manage loans',
            'manage eresources',
            'view public content',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Buat Roles
        $superAdmin = Role::firstOrCreate(['name' => 'super-admin']);
        $superAdmin->syncPermissions(Permission::all());

        $staffAdmin = Role::firstOrCreate(['name' => 'staff-admin']);
        $staffAdmin->syncPermissions([
            'manage artworks',
            'manage artists',
            'manage exhibitions',
            'manage auctions',
            'manage articles',
            'manage collections',
            'manage books',
            'manage members',
            'manage loans',
            'manage eresources',
        ]);

        $publicRole = Role::firstOrCreate(['name' => 'public']);
        $publicRole->syncPermissions(['view public content']);

        // Buat User Super Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@gallery.com'],
            ['name' => 'Super Admin', 'password' => Hash::make('password123')]
        );
        $admin->syncRoles(['super-admin']);

        // Buat User Staff
        $staff = User::firstOrCreate(
            ['email' => 'staff@gallery.com'],
            ['name' => 'Staff Admin', 'password' => Hash::make('password123')]
        );
        $staff->syncRoles(['staff-admin']);

        // Buat User Publik
        $public = User::firstOrCreate(
            ['email' => 'user@example.com'],
            ['name' => 'Pengunjung', 'password' => Hash::make('password123')]
        );
        $public->syncRoles(['public']);
    }
}
