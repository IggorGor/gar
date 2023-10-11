<?php

namespace App\Services;

use App\Models\Version;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Storage;

class GarService
{
    private static function getCmd(string $downloadUrl): string
    {
        if (config('gar.download_mode') == 'alternate')
            $downloadUrl = str_replace('fias-file', 'fias', $downloadUrl);
        return config('gar.wget_path') . 'wget ' . $downloadUrl . " -O " .
            Storage::path(config('gar.xml_full_zip_file_name')) . " -o " . Storage::path(config('gar.wget_log_file_name'));
    }

    private static function initDirectories(): void
    {
        if (!Storage::directoryExists('gar')) Storage::makeDirectory('gar');
    }

    private static function deleteOldFullZipFile(): void
    {
        if (Storage::exists(config('gar.xml_full_zip_file_name')))
            Storage::delete(config('gar.xml_full_zip_file_name'));
    }

    private static function deleteOldLogFile(): void
    {
        if (Storage::exists(config('gar.xml_full_zip_file_name')))
            Storage::delete(config('gar.xml_full_zip_file_name'));
    }

    public static function downloadFullGarArchive(): bool
    {
        $result = Http::get('https://fias.nalog.ru/WebServices/Public/GetLastDownloadFileInfo');
        if ($result->ok()) {
            $garArray = json_decode($result->body(), true);
            $version = Version::select('version')->latest()->limit(1)->first();
            if (is_null($version) or $version->version < $garArray['VersionId']) {
                GarService::initDirectories();
                GarService::deleteOldFullZipFile();
                GarService::deleteOldLogFile();
                $cmd = GarService::getCmd($garArray['GarXMLFullURL']);
                $processResult = Process::forever()->run($cmd);
                return $processResult->successful();
            }
        }
        return false;
    }

}
