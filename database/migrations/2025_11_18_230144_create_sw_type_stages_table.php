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
        Schema::create('sw_type_stages', function (Blueprint $table) {
            $table->id('typsta_id');
            $table->string('typsta_libelle', 100)->unique();
            $table->text('typsta_obs')->nullable();
            $table->boolean('actif')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sw_type_stages');
    }
};
