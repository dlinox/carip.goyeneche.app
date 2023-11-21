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
        Schema::create('person_phones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('person_id');
            $table->char('phone_number', 12)->check('LENGTH(phone_number) >= 9');
            $table->char('dial_code', 5)->default('+51');
            $table->boolean('has_whatsapp')->default(0);
            $table->boolean('is_active')->default(1);
            $table->timestamps();
            // Indexes
            $table->unique(['phone_number', 'person_id'], 'idx_phone_number_person_id');
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
        Schema::dropIfExists('person_phones');
    }
};
