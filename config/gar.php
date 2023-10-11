<?php

return [
    // Код обрабатываемого региона
    'region_code' => 37,

    // Путь к архиву полной выгрузки справочника ГАР
    'xml_full_zip_file_name' => 'gar/gar_full_xml.zip',

    // Путь к логу утилиты wget
    'wget_log_file_name' => 'gar/wget.log',

    // Путь к каталогу, для распаковки архива с полной выгрузкой
    'unzip_full_path' => 'gar/unzip/full',

    // Путь к каталогу, содержащему утилиту wget
    'wget_path' => 'D:/OSPanel/modules/wget/bin/',

    // Уровень логирования: 0 — не логировать, 1 — краткие логи, 2 — подробные логи
    'log_level' => 1, // 0, 1, 2

    // Режим скачивания: normal — скачивать с дефолтного адреса, alternate — скачивать с альтернативного адреса (медленно)
    'download_mode' => 'normal',
];
