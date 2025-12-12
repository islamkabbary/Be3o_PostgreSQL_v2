<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('reviewer_id')->unsigned();
            $table->foreign('reviewer_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('reviewee_id')->unsigned();
            $table->foreign('reviewee_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('ad_id')->unsigned()->nullable();
            $table->foreign('ad_id')->references('id')->on('ads')->onDelete('set null');
            $table->integer('rating');
            $table->string('title', 255)->nullable();
            $table->text('comment')->nullable();
            $table->string('transaction_type', 20)->nullable();
            $table->boolean('is_verified')->default(false);
            $table->boolean('is_anonymous')->default(false);
            $table->string('status', 20)->default('published');
            $table->integer('helpful_count')->default(0);
            $table->timestamps();
            
            $table->unique(['reviewer_id', 'reviewee_id', 'ad_id']);
        });

        DB::statement("ALTER TABLE reviews ADD CONSTRAINT chk_rating CHECK (rating BETWEEN 1 AND 5);");
        DB::statement("ALTER TABLE reviews ADD CONSTRAINT chk_transaction_type CHECK (transaction_type IN ('purchase', 'sale', 'rent'));");
        DB::statement("ALTER TABLE reviews ADD CONSTRAINT chk_status CHECK (status IN ('pending', 'published', 'hidden', 'reported'));");
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};