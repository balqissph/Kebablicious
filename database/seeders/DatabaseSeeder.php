<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Tetapkan role 'admin' ke user dengan ID 1
    $admin = \App\Models\User::find(2);
    $admin->assignRole('admin');
    }
}
