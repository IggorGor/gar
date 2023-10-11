<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('gar.param_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('desc');
            $table->string('code');
            $table->boolean('is_active');
            $table->date('update_date')->comment('Дата внесения (обновления) записи');
            $table->date('start_date')->comment('Начало действия записи');
            $table->date('end_date')->comment('Окончание действия записи');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gar.param_types');
    }
};
