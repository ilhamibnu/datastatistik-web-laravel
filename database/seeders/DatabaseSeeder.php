<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Role::create(['name' => 'Admin']);
        Role::create(['name' => 'Super Admin']);
        Role::create(['name' => 'User']);

        User::create([
            'name' => 'Admin',
            'id_role' => 1,
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin'),
            'foto' => '',
        ]);

        User::create([
            'name' => 'Super Admin',
            'id_role' => 2,
            'email' => 'superadmin@gmail.com',
            'password' => bcrypt('superadmin'),
            'foto' => '',
        ]);

        User::create([
            'name' => 'User',
            'id_role' => 3,
            'email' => 'user@gmail.com',
            'password' => bcrypt('user'),
            'foto' => '',
        ]);
    }
}
