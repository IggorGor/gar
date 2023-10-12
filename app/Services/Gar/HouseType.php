<?php

namespace App\Services\Gar;

class HouseType extends CommonGar
{

    protected function getTableName(): string
    {
        return 'gar.house_types';
    }

    protected function canProcessed(array $inputArray): bool
    {
        return true;
    }

    protected function getKeysArray(): array
    {
        return [
            'ID' => 'id',
            'NAME' => 'name',
            'SHORTNAME' => 'short_name',
            'DESC' => 'desc',
            'UPDATEDATE' => 'update_date',
            'STARTDATE' => 'start_date',
            'ENDDATE' => 'end_date',
            'ISACTIVE' => 'is_active',
        ];
    }
}
