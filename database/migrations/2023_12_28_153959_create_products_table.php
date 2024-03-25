<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            //category_id
            $table->foreignId('category_id')->nullable()->constrained('categories');
            $table->string('name', 100);
            $table->longText('description')->nullable();
            $table->json('product_attr')->nullable();
            $table->integer('quantity')->unsigned()->default(0)->nullable();
            $table->integer('remain')->unsigned()->default(0)->nullable();
            $table->string('warranty', 100)->nullable();
            $table->longText('remark')->nullable();
            $table->enum('status', ['enabled','disabled'])->default('enabled');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
