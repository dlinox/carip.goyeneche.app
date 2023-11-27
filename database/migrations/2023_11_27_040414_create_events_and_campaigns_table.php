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
        Schema::create('events_and_campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description');
            $table->string("slug")->nullable();
            $table->string('image');
            $table->text('content');
            $table->date('date_publish');
            $table->string('external_link')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('author')->nullable();
            $table->foreign('author')->references('id')->on('users')->onUpdate('cascade')->onDelete('no action');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events_and_campaigns');
    }
};
