<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('gar.object_levels', function (Blueprint $table) {
            $table->id()->comment('Уникальный идентификатор записи. Ключевое поле. Номер уровня объекта');
            $table->string('name', 250)->comment('Наименование');
            $table->string('short_name', 50)->nullable()->comment('Краткое наименование');
            $table->date('update_date')->comment('Дата внесения (обновления) записи');
            $table->date('start_date')->comment('Начало действия записи');
            $table->date('end_date')->comment('Окончание действия записи');
            $table->boolean('is_active')->comment('Статус активности');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gar.object_levels');
    }
};
