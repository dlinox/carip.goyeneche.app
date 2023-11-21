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
        Schema::create('persons', function (Blueprint $table) {
            $table->id();
            $table->string('name', 60);
            $table->string('father_last_name', 60)->nullable();
            $table->string('mother_last_name', 60)->nullable();
            $table->enum('document_type', ['DNI', 'CE', 'PAS', 'RUC'])->default('DNI');
            $table->char('document_number', 16)->check('LENGTH(document_number) >= 8');
            $table->enum('gender', ['M', 'F', 'NB'])->nullable()->comment('M: Masculino, F: Femenino, NB: No Binario');
            $table->date('birth_date')->nullable()->check('birth_date <= CURRENT_DATE');
            $table->unsignedBigInteger('birth_country_id')->nullable();
            $table->boolean('is_foreigner')->default(0);
            $table->boolean('is_active')->default(1);
            $table->char('phone', 9)->nullable();
            $table->timestamps();
            // Index
            $table->unique(['document_type', 'document_number'], 'idx_document');
            $table->fulltext(['name', 'father_last_name', 'mother_last_name'], 'idx_full_name');
            // Foreign key
            $table->foreign('birth_country_id')->references('id')->on('countries')->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('persons');
    }
};
