<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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
