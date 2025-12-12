<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('conversations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('ad_id')->unsigned();
            $table->foreign('ad_id')->references('id')->on('ads')->onDelete('cascade');
            $table->bigInteger('buyer_id')->unsigned();
            $table->foreign('buyer_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('seller_id')->unsigned();
            $table->foreign('seller_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('status', 20)->default('active');
            $table->timestampTz('last_message_at')->nullable();
            $table->timestamps();
            $table->unique(['ad_id', 'buyer_id', 'seller_id']);
        });

        DB::statement("ALTER TABLE conversations ADD CONSTRAINT chk_status CHECK (status IN ('active', 'archived', 'blocked'));");
    }

    public function down(): void
    {
        Schema::dropIfExists('conversations');
    }
};