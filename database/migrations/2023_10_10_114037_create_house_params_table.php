<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('gar.house_params', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('object_id');
            $table->index('object_id');
            $table->bigInteger('change_id');
            $table->integer('change_id_end');
            $table->integer('type_id');
            $table->index('type_id');
            $table->string('value');
            $table->date('update_date')->comment('Дата внесения (обновления) записи');
            $table->date('start_date')->comment('Начало действия записи');
            $table->date('end_date')->comment('Окончание действия записи');
            $table->index('end_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gar.house_params');
    }
};
