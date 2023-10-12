<?php

namespace App\Services\Gar;

use Illuminate\Support\Facades\DB;
use Log;

abstract class CommonGar
{
    private array $insertArray;
    private int $maxLineToSave;
    private int $alreadySave;

    public function __construct()
    {
        DB::table($this->getTableName())->truncate();
        if (config('gar.log_level') > 0) Log::info('Таблица ' . $this->getTableName() . ' очищена');
        $this->maxLineToSave = floor(65535 / count($this->getKeysArray()));
        $this->alreadySave = 0;
    }

    public function __destruct()
    {
        if (isset($this->insertArray) and count($this->insertArray) > 0) $this->saveToTable();
        if (config('gar.log_level') > 0) Log::info('Всего записано в таблицу ' . $this->getTableName() . ' ' . $this->alreadySave);
    }

    abstract protected function getTableName(): string;

    abstract protected function canProcessed(array $inputArray): bool;

    abstract protected function getKeysArray(): array;

    private function mapInputValues(array $inputValues): array
    {
        $keysArray = $this->getKeysArray();
        $output = [];
        foreach ($keysArray as $key => $newKey) {
            if (key_exists($key, $inputValues)) {
                $newValue = match ($inputValues[$key]) {
                    'true' => true,
                    'false' => false,
                    default => $inputValues[$key]
                };
            } else $newValue = null;
            $output[$newKey] = $newValue;
        }
        return $output;
    }

    private function clearInsertArray(): void
    {
        $this->insertArray = [];
    }

    private function saveToTable(): void
    {
        DB::table($this->getTableName())->insert($this->insertArray);
        $this->alreadySave += count($this->insertArray);
        if (config('gar.log_level') > 1) Log::info('Записано в таблицу ' . $this->getTableName() . ' ' . count($this->insertArray) . ' записей, всего: ' . $this->alreadySave);
    }

    private function processSave(): void
    {
        $this->saveToTable();
        $this->clearInsertArray();
    }

    public function addLine(array $inputArray): void
    {
        if ($this->canProcessed($inputArray)) $this->insertArray[] = $this->mapInputValues($inputArray);
        if (count($this->insertArray) >= $this->maxLineToSave) $this->processSave();
    }

}
