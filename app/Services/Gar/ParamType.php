<?php

namespace App\Services\Gar;

class ParamType extends CommonGar
{

    protected function getTableName(): string
    {
        return 'gar.param_types';
    }

    protected function canProcessed(array $inputArray): bool
    {
        return !(array_key_exists('ISACTIVE', $inputArray) and !$inputArray['ISACTIVE']);
    }

    protected function getKeysArray(): array
    {
        return [
            'ID' => 'id',
            'NAME' => 'name',
            'DESC' => 'desc',
            'CODE' => 'code',
            'ISACTIVE' => 'is_active',
            'UPDATEDATE' => 'update_date',
            'STARTDATE' => 'start_date',
            'ENDDATE' => 'end_date',
        ];
    }
}
