<?php

namespace App\Services\Gar;

class HouseParam extends CommonGar
{
    protected function getTableName(): string
    {
        return 'gar.house_params';
    }

    protected function canProcessed(array $inputArray): bool
    {
        return true;
    }

    protected function getKeysArray(): array
    {
        return [
            'ID' => 'id',
            'OBJECTID' => 'object_id',
            'CHANGEID' => 'change_id',
            'CHANGEIDEND' => 'change_id_end',
            'UPDATEDATE' => 'update_date',
            'STARTDATE' => 'start_date',
            'TYPEID' => 'type_id',
            'VALUE' => 'value',
            'ENDDATE' => 'end_date',
        ];
    }
}
