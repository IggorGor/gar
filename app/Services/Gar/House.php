<?php

namespace App\Services\Gar;

class House extends CommonGar
{

    protected function getTableName(): string
    {
        return 'gar.houses';
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
            'HOUSENUM' => 'house_num',
            'ADDNUM1' => 'add_num_1',
            'ADDNUM2' => 'add_num_2',
            'HOUSETYPE' => 'house_type',
            'ADDTYPE1' => 'add_type_1',
            'ADDTYPE2' => 'add_type_2',
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
