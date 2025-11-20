<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sw_droit', function (Blueprint $table) {
            $table->bigIncrements('droit_id');
            $table->enum('target_type', ['user', 'group']);
            $table->unsignedBigInteger('target_id');
            $table->string('module', 63);
            $table->unsignedTinyInteger('niveau')->default(0);
            $table->unsignedSmallInteger('createur_id')->nullable();
            $table->dateTime('ctime')->nullable();
            $table->timestamp('utime')->nullable();

            $table->index(['target_type', 'target_id', 'module']);
            $table->foreign('createur_id')->references('user_id')->on('sw_user')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sw_droit');
    }
};
