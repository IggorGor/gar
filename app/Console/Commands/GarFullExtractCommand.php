<?php

namespace App\Console\Commands;

use App\Services\GarService;
use Exception;
use Illuminate\Console\Command;

class GarFullExtractCommand extends Command
{
    protected $signature = 'gar:full-extract';

    protected $description = 'Command unzips the necessary files from the general upload';

    /**
     * @throws Exception
     */
    public function handle(): void
    {
        GarService::extractFullGar();
    }
}
