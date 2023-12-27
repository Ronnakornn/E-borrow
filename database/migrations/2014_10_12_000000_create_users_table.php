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

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('user_role', ['superAdmin', 'admin', 'company', 'customer'])->default('customer');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->json('user_info')->nullable();
            $table->string('user_img', 100)->nullable();
            $table->string('passport_id', 200)->nullable();
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
            $table->unique(['email', 'deleted_at']);
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
