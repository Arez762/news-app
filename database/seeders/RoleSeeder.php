<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Membuat role 'admin' jika belum ada
        Role::firstOrCreate(['name' => 'admin']);

        // Membuat role 'author' jika belum ada
        Role::firstOrCreate(['name' => 'author']);

        // Jika kamu ingin menambahkan beberapa izin (permissions), bisa dilakukan seperti ini:
        Permission::firstOrCreate(['name' => 'create articles']);
        Permission::firstOrCreate(['name' => 'edit articles']);
        Permission::firstOrCreate(['name' => 'delete articles']);
        Permission::firstOrCreate(['name' => 'publish articles']);

        // Menambahkan izin-izin tersebut ke role 'admin'
        $adminRole = Role::findByName('admin');
        $adminRole->givePermissionTo([
            'create articles',
            'edit articles',
            'delete articles',
            'publish articles',
        ]);

        // Menambahkan beberapa izin dasar ke role 'author' jika diperlukan
        $authorRole = Role::findByName('author');
        $authorRole->givePermissionTo([
            'create articles',
            'edit articles',
        ]);
    }
}
