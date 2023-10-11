<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gar.addr_objs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('object_id')->comment('Глобальный уникальный идентификатор объекта');
            $table->index('object_id');
            $table->uuid('object_guid')->comment('Глобальный уникальный идентификатор адресного объекта');
            $table->index('object_guid');
            $table->bigInteger('change_id')->comment('ID изменившей транзакции');
            $table->string('name', 250)->comment('Наименование');
            $table->string('type_name', 50)->comment('Краткое наименование типа объекта');
            $table->integer('level')->comment('Уровень адресного объекта');
            $table->index('level');
            $table->integer('oper_type_id')->comment('Статус действия над записью – причина появления записи');
            $table->bigInteger('prev_id')->nullable()->comment('Идентификатор записи связывания с предыдущей исторической записью');
            $table->bigInteger('next_id')->nullable()->comment('Идентификатор записи связывания с последующей исторической записью');
            $table->date('update_date')->comment('Дата внесения (обновления) записи');
            $table->date('start_date')->comment('Начало действия записи');
            $table->date('end_date')->comment('Окончание действия записи');
            $table->boolean('is_actual')->comment('Статус актуальности адресного объекта ФИАС');
            $table->boolean('is_active')->comment('Признак действующего адресного объекта');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gar.addr_objs');
    }
};
