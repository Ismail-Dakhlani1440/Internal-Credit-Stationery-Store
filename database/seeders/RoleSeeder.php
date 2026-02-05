<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::insert([
            ['id' => 1 ,'title' => 'admin'],
            ['id' => 2 ,'title' => 'manager'],
            ['id' => 3 ,'title' => 'employee']
        ]);
    }
}
