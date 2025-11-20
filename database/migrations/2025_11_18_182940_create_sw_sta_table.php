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
        Schema::create('sw_sta', function (Blueprint $table) {
            $table->id('sta_id');
            $table->unsignedBigInteger('createur_id')->nullable();
            $table->unsignedBigInteger('sta_tutpeda_id')->nullable();
            $table->unsignedBigInteger('sta_tutsoc_id')->nullable();
            $table->unsignedBigInteger('sta_soc_id')->nullable();
            $table->unsignedBigInteger('sta_etu_id')->nullable();
            $table->unsignedBigInteger('sta_typsta_id')->nullable();
            $table->string('sta_nom');
            $table->text('sta_obs')->nullable();
            $table->date('sta_debut')->nullable();
            $table->date('sta_fin')->nullable();
            $table->datetime('ctime')->nullable();
            $table->datetime('utime')->nullable();
            $table->boolean('actif')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sw_sta');
    }
};
