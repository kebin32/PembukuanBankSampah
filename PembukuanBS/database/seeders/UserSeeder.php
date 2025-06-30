<?php

namespace Database\Seeders;

use App\Models\User;
use Spatie\Permission\Models\Role;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder { public function run() { // Membuat role jika belum ada Role::firstOrCreate(['name' => 'admin']); Role::firstOrCreate(['name' => 'nasabah']); 
          // Membuat user dan menetapkan role
       $admin = User::create([
           'name' => 'Admin User',
           'email' => 'admin@example.com',
           'password' => bcrypt('password'), // Ganti dengan password yang aman
       ]);
       $admin->assignRole('admin');
       

        $nasabah = User::create([
            'name' => 'Nasabah User',
            'email' => 'nasabah@example.com',
            'password' => bcrypt('password'), // Ganti dengan password yang aman
        ]);
        $nasabah->assignRole('nasabah');
   }
   
}
