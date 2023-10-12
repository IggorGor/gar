<?php

namespace App\Services\Gar;

class AddrObj extends CommonGar
{
    protected function getTableName(): string
    {
        return 'gar.addr_objs';
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
            'OBJECTGUID' => 'object_guid',
            'CHANGEID' => 'change_id',
            'NAME' => 'name',
            'TYPENAME' => 'type_name',
            'LEVEL' => 'level',
            'OPERTYPEID' => 'oper_type_id',
            'PREVID' => 'prev_id',
            'NEXTID' => 'next_id',
            'UPDATEDATE' => 'update_date',
            'STARTDATE' => 'start_date',
            'ENDDATE' => 'end_date',
            'ISACTUAL' => 'is_actual',
            'ISACTIVE' => 'is_active',
        ];
    }
}
