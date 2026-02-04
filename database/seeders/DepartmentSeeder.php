<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       Department::insert([
         ['id' => 1, 'name' => 'Sales'],
            ['id' => 2, 'name' => 'Support'],
            ['id' => 3, 'name' => 'IT'],
            ['id' => 4, 'name' => 'Management'],
       ]);
    }
}
