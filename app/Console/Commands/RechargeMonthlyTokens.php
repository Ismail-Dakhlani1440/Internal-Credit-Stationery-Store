<?php

namespace App\Console\Commands;

use App\Jobs\RechargeMonthlyTokens as JobsRechargeMonthlyTokens;
use Illuminate\Console\Command;

class RechargeMonthlyTokens extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */


    /**
     * The console command description.
     *
     * @var string
     */
   

    /**
     * Execute the console command.
     */

    protected $signature = 'tokens:recharge';
    

    public function handle()
    {
        dispatch(new JobsRechargeMonthlyTokens());

     
    }
  
}
