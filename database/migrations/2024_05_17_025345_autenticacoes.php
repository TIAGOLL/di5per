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
        Schema::create('autenticacoes',function(Blueprint $table){
            $table->id();
            $table->string('token');
            $table->dateTime('expiraEm');
            $table->dateTime('atualizadoEm');
            $table->string('senha');
            $table->string('login');
            $table->foreignId('usuarios_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('autenticacoes');
    }
};
