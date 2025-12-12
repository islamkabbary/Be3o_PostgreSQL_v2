<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('type', 50);
            $table->string('title', 255);
            $table->text('message');
            $table->jsonb('data')->nullable();
            $table->boolean('is_read')->default(false);
            $table->string('delivery_method', 20)->nullable();
            $table->timestampTz('sent_at')->nullable();
            $table->timestampTz('read_at')->nullable();
            $table->timestamps();
        });

        DB::statement("ALTER TABLE notifications ADD CONSTRAINT chk_delivery_method CHECK (delivery_method IN ('push', 'email', 'sms', 'in_app'));");
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};