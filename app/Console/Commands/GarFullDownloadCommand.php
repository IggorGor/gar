<?php

namespace App\Console\Commands;

use App\Services\GarService;
use Exception;
use Illuminate\Console\Command;

class GarFullDownloadCommand extends Command
{
    protected $signature = 'gar:full-download';

    protected $description = 'Command download full GAR archive from server';

    public function handle(): void
    {
        GarService::downloadFullGarArchive();
    }
}
