<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Role;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        Role::insert([
            ['id' => 1 ,'title' => 'admin'],
            ['id' => 2 ,'title' => 'manager'],
            ['id' => 3 ,'title' => 'employee']
        ]);
        foreach(Department::all() as $department){
            User::factory()->create([
                'role_id'=>2,
                'department_id'=> $department->id,
                'tokens' => 2000
            ]);
        } 
        User::factory(30)->create([
            'role_id' => 3,
            'department_id' => Department::inRandomOrder()->value('id'),
            'tokens' => 2000
        ]);
    }
}
