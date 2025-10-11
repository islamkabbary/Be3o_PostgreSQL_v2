<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 100);
            $table->string('email', 255)->unique();
            $table->string('phone', 20)->unique()->nullable();
            $table->string('password', 255);
            $table->string('avatar_url', 500)->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('gender', 10)->nullable();

            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('phone_verified_at')->nullable();

            $table->string('account_type', 20)->default('individual');
            $table->string('account_status', 20)->default('active');
            $table->string('preferred_language', 5)->default('en');

            $table->timestamp('last_login_at')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        DB::statement("ALTER TABLE users ADD CONSTRAINT chk_gender CHECK (gender IN ('male', 'female', 'other'));");
        DB::statement("ALTER TABLE users ADD CONSTRAINT chk_account_type CHECK (account_type IN ('individual', 'business', 'dealer'));");
        DB::statement("ALTER TABLE users ADD CONSTRAINT chk_account_status CHECK (account_status IN ('active', 'suspended', 'banned', 'deleted'));");
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
