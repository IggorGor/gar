<?php

namespace App\Services;

use App\Models\Version;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class GarService
{

    private static array $regFileNames = [
        'AS_OBJECT_LEVELS' => '/^AS_OBJECT_LEVELS_\d{8}_[0-9abcdef]{8}-[0-9abcdef]{4}-[0-9abcdef]{4}-[0-9abcdef]{4}-[0-9abcdef]{12}.XML$/i',
        'AS_HOUSE_TYPES' => '/^AS_HOUSE_TYPES_\d{8}_[0-9abcdef]{8}-[0-9abcdef]{4}-[0-9abcdef]{4}-[0-9abcdef]{4}-[0-9abcdef]{12}.XML$/i',
        'AS_ADDHOUSE_TYPES' => '/^AS_ADDHOUSE_TYPES_\d{8}_[0-9abcdef]{8}-[0-9abcdef]{4}-[0-9abcdef]{4}-[0-9abcdef]{4}-[0-9abcdef]{12}.XML$/i',
        'AS_PARAM_TYPES' => '/^AS_PARAM_TYPES_\d{8}_[0-9abcdef]{8}-[0-9abcdef]{4}-[0-9abcdef]{4}-[0-9abcdef]{4}-[0-9abcdef]{12}.XML$/i',
        'AS_HOUSES_PARAMS' => '/^AS_HOUSES_PARAMS_\d{8}_[0-9abcdef]{8}-[0-9abcdef]{4}-[0-9abcdef]{4}-[0-9abcdef]{4}-[0-9abcdef]{12}.XML$/i',
        'AS_ADDR_OBJ' => '/^AS_ADDR_OBJ_\d{8}_[0-9abcdef]{8}-[0-9abcdef]{4}-[0-9abcdef]{4}-[0-9abcdef]{4}-[0-9abcdef]{12}.XML$/i',
        'AS_ADM_HIERARCHY' => '/^AS_ADM_HIERARCHY_\d{8}_[0-9abcdef]{8}-[0-9abcdef]{4}-[0-9abcdef]{4}-[0-9abcdef]{4}-[0-9abcdef]{12}.XML$/i',
        'AS_HOUSES' => '/^AS_HOUSES_\d{8}_[0-9abcdef]{8}-[0-9abcdef]{4}-[0-9abcdef]{4}-[0-9abcdef]{4}-[0-9abcdef]{12}.XML$/i',
    ];

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

    public static function extractFullGar(): bool
    {
        $zip = new ZipArchive();
        $status = $zip->open(Storage::path(config('gar.xml_full_zip_file_name')));
        if ($status !== true) return false;
        else {
            self::deleteOldUnzipFiles();
            self::makeUnzipDirectory();
            $extractArray = self::getExtractFiles($zip);
            if (count($extractArray) != 0)
                $zip->extractTo(Storage::path(config('gar.unzip_full_path')), $extractArray);

        }
        $zip->close();
        return true;
    }

    private static function getExtractFiles(ZipArchive $zip): array
    {
        $extractArray = [];
        for ($i = 0; $i < $zip->count(); $i++) {
            $fileName = $zip->getNameIndex($i);
            $dir = dirname($fileName);
            if (($dir == '.' or $dir == config('gar.region_code')) and self::verifyFileName($fileName))
                $extractArray[] = $fileName;
        }
        return $extractArray;
    }

    private static function deleteOldUnzipFiles(): void
    {
        if (Storage::directoryExists(config('gar.unzip_full_path')))
            Storage::deleteDirectory(config('gar.unzip_full_path'));
    }

    private static function makeUnzipDirectory(): void
    {
        if (!Storage::directoryExists(config('gar.unzip_full_path'))) {
            Storage::makeDirectory(config('gar.unzip_full_path'));
        }
    }

    private static function verifyFileName(string $fileName): bool
    {
        foreach (self::$regFileNames as $regFileName) {
            if (preg_match($regFileName, basename($fileName))) return true;
        }
        return false;
    }

}
