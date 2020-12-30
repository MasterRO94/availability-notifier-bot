<?php

namespace App\Console\Commands;

use App\Jobs\CheckAvailability as CheckAvailabilityJob;
use Illuminate\Console\Command;

class CheckAvailability extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bot:check-availability';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check PS5 availability in stocks';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        CheckAvailabilityJob::dispatch();

        return 0;
    }
}
