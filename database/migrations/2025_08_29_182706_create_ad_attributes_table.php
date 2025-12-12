<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ad_attributes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('ad_id')->unsigned();
            $table->foreign('ad_id')->references('id')->on('ads')->onDelete('cascade');
            $table->bigInteger('attribute_id')->unsigned();
            $table->foreign('attribute_id')->references('id')->on('category_attributes');
            $table->text('value_text')->nullable();
            $table->decimal('value_number', 15, 4)->nullable();
            $table->boolean('value_boolean')->nullable();
            $table->date('value_date')->nullable();
            $table->jsonb('value_json')->nullable();
            $table->timestamps();
            $table->unique(['ad_id', 'attribute_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ad_attributes');
    }
};