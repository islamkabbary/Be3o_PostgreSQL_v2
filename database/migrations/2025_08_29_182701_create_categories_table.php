<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('parent_id')->unsigned()->nullable(); // parent category
            $table->foreign('parent_id')->references('id')->on('categories')->onDelete('cascade');
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('slug', 100)->unique();
            $table->string('icon_url', 500)->nullable();
            $table->string('image_url', 500)->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->boolean('requires_verification')->default(false);
            $table->boolean('allows_negotiation')->default(true);
            $table->string('meta_title', 200)->nullable();
            $table->text('meta_description')->nullable();
            $table->timestampTz('created_at')->useCurrent();
            $table->timestampTz('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->unique(['parent_id', 'slug']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
