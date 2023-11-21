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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('person_id');
            $table->string('fullname');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->enum('role', ['Super Admin', 'Administrador', 'Operador'])->default('Administrador');
            $table->string('password');
            $table->boolean('is_active')->default(1);
            $table->rememberToken();
            $table->timestamps();

            // Index
            $table->index('person_id', 'idx_person_id');
            // Foreign key
            $table->foreign('person_id')->references('id')->on('persons')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
