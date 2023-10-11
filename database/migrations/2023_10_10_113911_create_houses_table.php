<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('gar.houses', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('object_id')->comment('Глобальный уникальный идентификатор объекта');
            $table->index('object_id');
            $table->uuid('object_guid')->comment('Глобальный уникальный идентификатор адресного объекта');
            $table->index('object_guid');
            $table->bigInteger('change_id')->comment('ID изменившей транзакции');
            $table->string('house_num', 50)->nullable()->comment('Основной номер дома');
            $table->string('add_num_1', 50)->nullable()->comment('Дополнительный номер дома 1');
            $table->string('add_num_2', 50)->nullable()->comment('Дополнительный номер дома 2');
            $table->bigInteger('house_type')->nullable()->comment('Основной тип дома');
            $table->index('house_type');
            $table->bigInteger('add_type_1')->nullable()->comment('Дополнительный тип дома 1');
            $table->index('add_type_1');
            $table->bigInteger('add_type_2')->nullable()->comment('Дополнительный тип дома 2');
            $table->index('add_type_2');
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
        Schema::dropIfExists('gar.houses');
    }
};
