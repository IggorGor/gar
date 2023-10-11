<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        if (config('database.default') === 'pgsql') DB::unprepared('create schema if not exists gar');
    }

    public function down(): void
    {
        if (config('database.default') === 'pgsql') DB::unprepared('drop schema if exists gar');
    }
};
