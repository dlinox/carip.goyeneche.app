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
        Schema::create('person_photos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('person_id');
            $table->string('path');
            $table->string('filename');
            $table->string('mime_type')->nullable();
            $table->string('extension')->nullable();
            $table->string('size')->nullable();
            $table->boolean('is_avatar')->default(0);
            $table->boolean('is_main')->default(0);
            $table->boolean('is_active')->default(1);
            $table->timestamps();
            $table->foreign('person_id')->references('id')->on('persons')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('person_photos');
    }
};
