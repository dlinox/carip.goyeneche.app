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
        Schema::create('final_services', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('img_path');
            $table->string('description');
            $table->unsignedBigInteger('specialty_id');
            $table->unsignedBigInteger('worker_id');
            $table->boolean('is_active')->default(true);

            $table->foreign('worker_id')->references('id')->on('workers');
            $table->foreign('specialty_id')->references('id')->on('specialties');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('final_services');
    }
};
