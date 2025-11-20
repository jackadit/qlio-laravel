<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sw_l_user_groupe', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->unsignedSmallInteger('groupe_id');

            $table->primary(['user_id', 'groupe_id']);

            $table->foreign('user_id')->references('user_id')->on('sw_user')->cascadeOnDelete();
            $table->foreign('groupe_id')->references('groupe_id')->on('sw_groupe')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sw_l_user_groupe');
    }
};
