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
        Schema::create('intermediate_services', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('img_path');
            $table->string('description');
            $table->unsignedBigInteger('supporting_service_id');
            $table->foreign('supporting_service_id')->references('id')->on('supporting_services');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('intermediate_services');
    }
};
