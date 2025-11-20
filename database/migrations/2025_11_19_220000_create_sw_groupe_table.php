<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sw_groupe', function (Blueprint $table) {
            $table->smallIncrements('groupe_id');
            $table->unsignedSmallInteger('createur_id')->nullable();
            $table->unsignedSmallInteger('groupe_org_id')->nullable();
            $table->string('groupe_nom', 30);
            $table->unsignedTinyInteger('groupe_type')->default(3);
            $table->dateTime('ctime')->nullable();
            $table->timestamp('utime')->nullable();
            $table->unsignedTinyInteger('actif')->default(1);

            $table->foreign('createur_id')->references('user_id')->on('sw_user')->nullOnDelete();
            $table->foreign('groupe_org_id')->references('user_id')->on('sw_user')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sw_groupe');
    }
};
