<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('key', 100)->unique();
            $table->text('value')->nullable();
            $table->string('data_type', 20)->default('string');
            $table->text('description')->nullable();
            $table->boolean('is_public')->default(false);
            $table->timestamps();
            
        });

        DB::statement("ALTER TABLE settings ADD CONSTRAINT chk_data_type CHECK (data_type IN ('string', 'integer', 'boolean', 'json'));");
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};