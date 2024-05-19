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
        Schema::create('moedas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('descricao', 100);
            $table->string('simbolo', 5);
            $table->string('sigla', 5);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('moedas');
    }
};
