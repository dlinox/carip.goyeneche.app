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
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
            $table->char('dial_code', 8);
            $table->enum('continent', [
                'África',
                'América del Norte',
                'América del Sur',
                'Asia',
                'Europa',
                'Oceanía',
                'Antártida'
            ])->default('América del Sur');
            $table->char('code', 2)->charset('ASCII')->unique();
            $table->boolean('is_active')->default(1);
            // Index
            $table->index('code', 'idx_code');
            $table->index('name', 'idx_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};
