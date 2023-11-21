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
        Schema::create('person_addresses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('person_id');
            $table->unsignedBigInteger('country_id')->nullable();
            $table->char('ubigeo_code', 6)->nullable();
            $table->string('address', 150);
            $table->string('reference', 100)->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->boolean('is_main')->default(0);
            $table->boolean('is_active')->default(1);
            $table->timestamps();

            // Indexes
            $table->index('person_id', 'idx_person_id');

            // Foreign keys
            $table->foreign('person_id')->references('id')->on('persons')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('country_id')->references('id')->on('countries')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('ubigeo_code')->references('code')->on('ubigeos')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('person_addresses');
    }
};
