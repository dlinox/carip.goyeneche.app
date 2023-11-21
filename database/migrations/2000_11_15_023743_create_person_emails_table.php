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
        Schema::create('person_emails', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('person_id');
            $table->string('email', 100)->unique();
            $table->boolean('is_username')->default(0);
            $table->boolean('is_verified')->default(0);
            $table->boolean('is_active')->default(1);
            $table->timestamps();

            // Indexes
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
        Schema::dropIfExists('person_emails');
    }
};
