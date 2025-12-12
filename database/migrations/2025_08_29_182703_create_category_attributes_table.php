<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('category_attributes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->jsonb('name');
            $table->string('attribute_type', 20);
            $table->boolean('is_required')->default(false);
            $table->boolean('is_searchable')->default(false);
            $table->boolean('is_filterable')->default(false);
            $table->string('filter_type')->nullable();
            $table->jsonb('options')->nullable();
            $table->jsonb('validation_rules')->nullable();
            $table->integer('sort_order')->default(0);
            $table->string('depends_on')->nullable();
            $table->timestamps();
        });

        DB::statement("
            ALTER TABLE category_attributes
            ADD CONSTRAINT chk_attribute_type
            CHECK (attribute_type IN (
                'text','number','select','multiselect','boolean','checkbox','radio','currency','date','time','datetime','file','image','color'
            ));
        ");
    }

    public function down(): void
    {
        Schema::dropIfExists('category_attributes');
    }
};