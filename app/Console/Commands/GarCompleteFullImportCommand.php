<?php

namespace App\Console\Commands;

use App\Services\GarService;
use Exception;
use Illuminate\Console\Command;

class GarCompleteFullImportCommand extends Command
{
    protected $signature = 'gar:complete-full-import';

    protected $description = 'Command performs full import to the database';

    /**
     * @throws Exception
     */
    public function handle(): void
    {
        if (GarService::downloadFullGarArchive())
            if (GarService::extractFullGar()) {
                GarService::setImportJobs();
                $this->call('gar:start-workers');
            }
    }
}
