<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('listings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('categories');
            $table->string('title', 255);
            $table->text('description');
            $table->decimal('price', 12, 2)->nullable();
            $table->string('currency', 3)->default('EGP');
            $table->boolean('price_negotiable')->default(true);
            $table->string('condition', 20)->nullable();
            $table->string('country', 100)->default('Egypt');
            $table->string('governorate', 100);
            $table->string('city', 100);
            $table->string('area', 100)->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('status', 20)->default('draft');
            $table->string('listing_type', 20)->default('sell');
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_urgent')->default(false);
            $table->boolean('is_premium')->default(false);
            $table->boolean('auto_renew')->default(false);
            $table->integer('priority_score')->default(0);
            $table->integer('contact_count')->default(0);
            $table->integer('favorite_count')->default(0);
            $table->string('slug', 300)->unique()->nullable();
            $table->string('meta_title', 200)->nullable();
            $table->text('meta_description')->nullable();
            $table->timestampTz('published_at')->nullable();
            $table->timestampTz('expires_at')->nullable();
            $table->timestampTz('created_at')->useCurrent();
            $table->timestampTz('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        DB::statement("ALTER TABLE listings ADD COLUMN location geography(POINT);");
        DB::statement("ALTER TABLE listings ADD CONSTRAINT chk_condition CHECK (condition IN ('new', 'used', 'refurbished'));");
        DB::statement("ALTER TABLE listings ADD CONSTRAINT chk_status CHECK (status IN ('draft', 'active', 'sold', 'expired', 'removed', 'suspended'));");
        DB::statement("ALTER TABLE listings ADD CONSTRAINT chk_listing_type CHECK (listing_type IN ('sell', 'rent', 'exchange', 'wanted'));");
    }

    public function down(): void
    {
        Schema::dropIfExists('listings');
    }
};