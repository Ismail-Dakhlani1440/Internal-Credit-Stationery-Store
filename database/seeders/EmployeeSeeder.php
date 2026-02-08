<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str as SupportStr;
use Psy\Util\Str;

use function Illuminate\Support\now;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         User::create([
            'name' => 'oussama',
            'email' => 'oussama@gmail.com',
            'email_verified_at' => now(),
            'tokens' => 5000,
            'role_id'=>3,
            'department_id' => 1,
            'password' =>  Hash::make('password'),
            'remember_token' => SupportStr::random(10),
        ]);
    }
}
