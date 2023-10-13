<?php

namespace App\Console\Commands;

use App\Services\GarService;
use Exception;
use Illuminate\Console\Command;

class GarFullImportCommand extends Command
{
    protected $signature = 'gar:full-import';

    protected $description = 'Command import full download from GAR';

    /**
     * @throws Exception
     */
    public function handle(): void
    {
        GarService::setImportJobs();
    }
}
