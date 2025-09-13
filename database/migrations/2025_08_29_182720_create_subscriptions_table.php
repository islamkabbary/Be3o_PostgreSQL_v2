<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('plan_id')->unsigned();
            $table->foreign('plan_id')->references('id')->on('subscription_plans')->onDelete('cascade');
            $table->string('status', 20)->default('active');
            $table->timestampTz('start_date');
            $table->timestampTz('end_date')->nullable();
            $table->decimal('cost', 12, 2)->nullable();
            $table->decimal('discount_percentage', 5, 2)->default(0);
            $table->boolean('is_free')->default(false);
            $table->bigInteger('granted_by')->unsigned()->nullable();
            $table->foreign('granted_by')->references('id')->on('admin_users');
            $table->text('reason')->nullable();
            $table->text('payment_method_note')->nullable();
            $table->text('notes')->nullable();
            $table->timestampTz('created_at')->useCurrent();
            $table->timestampTz('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->unique(['user_id', 'plan_id']);
        });

        DB::statement("ALTER TABLE subscriptions ADD CONSTRAINT chk_status CHECK (status IN ('active', 'pending', 'expired', 'cancelled'));");
    }

    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
  
    }
};