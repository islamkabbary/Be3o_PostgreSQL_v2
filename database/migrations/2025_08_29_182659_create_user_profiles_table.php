<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->text('about_me')->nullable();
            $table->string('business_name', 200)->nullable();
            $table->string('business_type', 50)->nullable();
            $table->string('company_size', 20)->nullable();
            $table->string('website_url', 500)->nullable();
            $table->string('social_facebook', 200)->nullable();
            $table->string('social_instagram', 200)->nullable();
            $table->string('social_twitter', 200)->nullable();
            $table->string('trade_license', 100)->nullable();
            $table->string('tax_number', 100)->nullable();
            $table->boolean('notification_email')->default(true);
            $table->boolean('notification_sms')->default(true);
            $table->boolean('notification_push')->default(true);
            $table->boolean('privacy_show_phone')->default(true);
            $table->boolean('privacy_show_email')->default(false);
            $table->timestamps();
            
            $table->unique('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};