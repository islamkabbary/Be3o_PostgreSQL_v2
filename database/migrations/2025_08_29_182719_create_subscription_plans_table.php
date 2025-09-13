<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('plan_type', 50)->unique();
            $table->string('name', 100);
            $table->string('name_ar', 100);
            $table->text('description')->nullable();
            $table->decimal('default_cost', 12, 2)->nullable();
            $table->string('billing_cycle', 20)->nullable();
            $table->jsonb('features')->nullable();
            $table->integer('max_listings')->default(0);
            $table->integer('priority_level')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestampTz('created_at')->useCurrent();
            $table->timestampTz('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        DB::statement("ALTER TABLE subscription_plans ADD CONSTRAINT chk_billing_cycle CHECK (billing_cycle IN ('monthly', 'yearly', 'one_time'));");
    }

    public function down(): void
    {
        Schema::dropIfExists('subscription_plans');
    }
};