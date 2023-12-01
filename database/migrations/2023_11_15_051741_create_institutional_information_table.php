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
        Schema::create('institutional_information', function (Blueprint $table) {
            $table->id();
            $table->string('name', 120);
            $table->string('description');
            $table->string('address', 180); //otra tabla
            $table->char('phone', 9); //otra tabla
            $table->string('email', 120); //otra tabla
            // $table->string('email_MESA DE PARTES', 120); //otra tabla
            $table->text('about_us')->nullable();
            $table->text('mission');
            $table->text('vision');
            $table->text('values')->nullable();
            $table->text('motto')->nullable();
            $table->string('organigram'); //imagen
            $table->string('organizational_structure')->nullable();
            $table->text('history')->nullable();
            $table->text('logo')->nullable();
            $table->text('favicon')->nullable();
            $table->text('facebook')->nullable(); //otra tabla  redes sociales
            $table->text('twitter')->nullable(); //otra tabla   redes
            $table->text('instagram')->nullable(); //otra tabla redes
            $table->text('youtube')->nullable(); //otra tabla   redes
            $table->text('whatsapp')->nullable(); //otra tabla  redes
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('institutional_information');
    }
};
