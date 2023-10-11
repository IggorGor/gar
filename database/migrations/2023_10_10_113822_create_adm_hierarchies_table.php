<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('gar.adm_hierarchies', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('object_id')->comment('Глобальный уникальный идентификатор объекта');
            $table->index('object_id');
            $table->bigInteger('parent_obj_id')->comment('Идентификатор родительского объекта');
            $table->index('parent_obj_id');
            $table->bigInteger('change_id')->comment('ID изменившей транзакции');
            $table->string('region_code', 4)->nullable()->comment('Код региона');
            $table->string('area_code', 4)->nullable()->comment('Код района');
            $table->string('city_code', 4)->nullable()->comment('Код города');
            $table->string('place_code', 4)->nullable()->comment('Код населенного пункта');
            $table->string('plan_code', 4)->nullable()->comment('Код ЭПС');
            $table->string('street_code', 4)->nullable()->comment('Код улицы');
            $table->bigInteger('prev_id')->nullable()->comment('Идентификатор записи связывания с предыдущей исторической записью');
            $table->bigInteger('next_id')->nullable()->comment('Идентификатор записи связывания с последующей исторической записью');
            $table->date('update_date')->comment('Дата внесения (обновления) записи');
            $table->date('start_date')->comment('Начало действия записи');
            $table->date('end_date')->comment('Окончание действия записи');
            $table->boolean('is_active')->comment('Признак действующего адресного объекта');
            $table->string('path')->comment('Материализованный путь к объекту (полная иерархия)');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gar.adm_hierarchies');
    }
};
