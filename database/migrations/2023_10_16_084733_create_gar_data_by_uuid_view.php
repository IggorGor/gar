<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
        $sql = "
drop view if exists gar.gar_data_by_uuid;

create view gar.gar_data_by_uuid as
SELECT COALESCE(hp.value, 'Не задан')                    AS post_index,
       ao1.object_id                                     AS city_object_id,
       ao1.object_guid                                   AS city_object_guid,
       ao1.type_name                                     AS city_type_name,
       ao1.name                                          AS city_name,
       ol1.short_name                                    AS city_level_short_name,
       ol1.name                                          AS city_level_name,
       ao.object_id                                      AS street_object_id,
       ao.object_guid                                    AS street_object_guid,
       ao.type_name                                      AS street_type_name,
       ao.name                                           AS street_name,
       ol.name                                           AS street_level_name,
       ol.short_name                                     AS street_level_short_name,
       h.object_id                                       AS house_object_id,
       h.object_guid                                     AS house_object_guid,
       ht.name                                           AS house_type_name,
       ht.short_name                                     AS house_type_short_name,
       h.house_num,
       hat.short_name                                    AS house_add_type_1_short_name,
       hat.name                                          AS house_add_type_1_name,
       h.add_num_1                                       AS house_add_num_1,
       hat1.short_name                                   AS house_add_type_2_short_name,
       hat1.name                                         AS house_add_type_2_name,
       h.add_num_2                                       AS house_add_num_2,
       h.is_active                                       AS house_active
FROM gar.houses h
         LEFT JOIN gar.adm_hierarchies ah ON ah.object_id = h.object_id AND ah.is_active = true
         LEFT JOIN gar.adm_hierarchies ah1 ON ah1.object_id = ah.parent_obj_id AND ah1.is_active = true
         LEFT JOIN gar.addr_objs ao ON ao.object_id = ah.parent_obj_id AND ao.is_active = true
         LEFT JOIN gar.addr_objs ao1 ON ao1.object_id = ah1.parent_obj_id AND ao1.is_active = true
         LEFT JOIN gar.house_types ht ON ht.id = h.house_type AND ht.is_active = true
         LEFT JOIN gar.house_add_types hat ON hat.id = h.add_type_1 AND hat.is_active = true
         LEFT JOIN gar.house_add_types hat1 ON hat1.id = h.add_type_2 AND hat1.is_active = true
         LEFT JOIN gar.object_levels ol ON ol.id = ao.level AND ol.is_active = true
         LEFT JOIN gar.object_levels ol1 ON ol1.id = ao1.level AND ol1.is_active = true
         LEFT JOIN gar.house_params hp ON hp.object_id = h.object_id AND hp.type_id = 5 AND hp.end_date >= now()
WHERE h.is_actual = true";
        DB::unprepared($sql);
    }

    public function down(): void
    {
        DB::unprepared('drop view if exists gar.gar_data_by_uuid;');
    }
};
