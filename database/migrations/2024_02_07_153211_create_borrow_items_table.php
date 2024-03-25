<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('borrow_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('borrow_id')->constrained( table: 'borrows')->cascadeOnDelete()->comment('ไอดีการยืม');
            $table->foreignId('product_id')->constrained()->nullable()->comment('ไอดีผู้ใช้');
            $table->foreignId('product_item_id')->constrained( table: 'product_items' )->nullable()->comment('ไอดีสินค้า');
            $table->string('product_name', 100)->nullable();
            $table->integer('amount')->nullable()->unsigned()->comment('จำนวน');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrow_items');
    }
};
