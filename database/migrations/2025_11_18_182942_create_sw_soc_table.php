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
        Schema::create('sw_soc', function (Blueprint $table) {
            $table->id('soc_id');
            $table->string('soc_nom');
            $table->string('soc_adresse')->nullable();
            $table->string('soc_ville')->nullable();
            $table->string('soc_cp')->nullable();
            $table->string('soc_pays')->nullable();
            $table->string('soc_tel')->nullable();
            $table->string('soc_email')->nullable();
            $table->text('soc_description')->nullable();
            $table->boolean('soc_actif')->default(true);
            $table->datetime('ctime')->nullable();
            $table->datetime('utime')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sw_soc');
    }
};
