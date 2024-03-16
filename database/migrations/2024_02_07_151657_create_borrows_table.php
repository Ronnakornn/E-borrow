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

        Schema::create('borrows', function (Blueprint $table) {
            $table->id();
            $table->longText('borrow_number')->comment('เลขการยืม');
            $table->longText('note')->nullable();
            $table->date('borrow_date')->comment('วันที่ยืม');
            $table->dateTime('borrow_date_return')->comment('วันที่คืน');
            $table->enum('status', ['pending', 'confirmed', 'canceled', 'returned'])->default('pending')->comment('สถานะการยืม');

            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrows');
    }
};
