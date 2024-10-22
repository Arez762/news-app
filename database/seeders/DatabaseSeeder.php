<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Membuat role 'admin' jika belum ada
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // Membuat role 'author' jika belum ada
        $authorRole = Role::firstOrCreate(['name' => 'author']);

        // Membuat atau mengambil pengguna dengan ID tertentu
        $user = User::firstOrCreate(
            ['email' => 'admin@example.com'], // Ganti dengan email pengguna yang ingin dijadikan admin
            [
                'name' => 'Admin User', // Ganti dengan nama yang sesuai
                'password' => bcrypt('password'), // Ganti dengan password yang sesuai
            ]
        );

        // Menetapkan role 'admin' kepada pengguna
        $user->assignRole($adminRole);

        // Seed data lainnya jika ada
        $this->call([
            // Tambahkan seeder lain di sini jika ada
            RoleSeeder::class, // Misalnya jika ada seeder khusus untuk role dan permission
        ]);
    }
}
