<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Process\Pool;
use Illuminate\Support\Facades\Process;

class GarStartWorkersCommand extends Command
{
    protected $signature = 'gar:start-workers';

    protected $description = 'Command description';

    public function handle(): void
    {
        Process::pool(function (Pool $pool) {
            for ($i = 0; $i < config('gar.num_workers'); $i++) {
                $pool->path(base_path())->timeout(3600)->command('php artisan queue:work --stop-when-empty');
            }
        })->start()->wait();
    }
}
