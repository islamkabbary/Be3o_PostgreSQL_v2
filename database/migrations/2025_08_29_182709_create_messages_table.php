<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('conversation_id')->unsigned();
            $table->foreign('conversation_id')->references('id')->on('conversations')->onDelete('cascade');
            $table->bigInteger('sender_id')->unsigned();
            $table->foreign('sender_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('recipient_id')->unsigned();
            $table->foreign('recipient_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('message_type', 20)->default('text');
            $table->text('content');
            $table->string('attachment_url', 500)->nullable();
            $table->decimal('offer_amount', 12, 2)->nullable();
            $table->boolean('is_read')->default(false);
            $table->boolean('is_system')->default(false);
            $table->timestampTz('sent_at')->useCurrent();
            $table->timestampTz('read_at')->nullable();
        });

        DB::statement("ALTER TABLE messages ADD CONSTRAINT chk_message_type CHECK (message_type IN ('text', 'image', 'system', 'offer'));");
    }

    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};