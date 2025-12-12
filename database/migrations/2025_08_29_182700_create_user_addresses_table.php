<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('label', 50);
            $table->string('country', 100);
            $table->string('governorate', 100);
            $table->string('city', 100);
            $table->string('area', 100)->nullable();
            $table->text('street_address')->nullable();
            $table->string('building_number', 20)->nullable();
            $table->string('apartment_number', 20)->nullable();
            $table->string('postal_code', 20)->nullable();
            $table->text('landmark')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->boolean('is_primary')->default(false);
            $table->timestamps();
            
        });

        DB::statement('ALTER TABLE user_addresses ADD COLUMN location geography(POINT);');
    }

    public function down(): void
    {
        Schema::dropIfExists('user_addresses');
    }
};