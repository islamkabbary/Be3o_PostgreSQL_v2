<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('CREATE EXTENSION IF NOT EXISTS "pg_trgm";');
        DB::statement('CREATE EXTENSION IF NOT EXISTS "unaccent";');
        // DB::statement('CREATE EXTENSION IF NOT EXISTS "postgis";');
    }

    public function down(): void
    {
        // DB::statement('DROP EXTENSION IF EXISسTS "postgis";');
        DB::statement('DROP EXTENSION IF EXISTS "unaccent";');
        DB::statement('DROP EXTENSION IF EXISTS "pg_trgm";');
    }
};