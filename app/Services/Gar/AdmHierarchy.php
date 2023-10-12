<?php

namespace App\Services\Gar;

class AdmHierarchy extends CommonGar
{
    protected function getTableName(): string
    {
        return 'gar.adm_hierarchies';
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
            'PARENTOBJID' => 'parent_obj_id',
            'CHANGEID' => 'change_id',
            'REGIONCODE' => 'region_code',
            'AREACODE' => 'area_code',
            'CITYCODE' => 'city_code',
            'PLACECODE' => 'place_code',
            'PLANCODE' => 'plan_code',
            'STREETCODE' => 'street_code',
            'PREVID' => 'prev_id',
            'NEXTID' => 'next_id',
            'UPDATEDATE' => 'update_date',
            'STARTDATE' => 'start_date',
            'ENDDATE' => 'end_date',
            'ISACTIVE' => 'is_active',
            'PATH' => 'path',
        ];
    }
}
