<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;

class RechargeMonthlyTokens implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
       
    DB::table('users')
    ->join('roles', 'users.role_id', '=', 'roles.id')
    ->where('roles.title', '!=', 'admin')
    ->update(['tokens' => 2000]);
    }
}
