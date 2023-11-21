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
        Schema::create('organization_charts', function (Blueprint $table) {
            $table->id();

            $table->string('position', 120);
            $table->integer('level')->default(0);
            $table->unsignedBigInteger('worker_id')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();

            $table->foreign('worker_id')->references('id')->on('workers')->onDelete('cascade');
            $table->foreign('parent_id')->references('id')->on('organization_charts')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organization_charts');
    }
};
