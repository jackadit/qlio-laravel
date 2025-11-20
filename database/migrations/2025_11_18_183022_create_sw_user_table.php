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
        Schema::create('sw_user', function (Blueprint $table) {
            $table->smallIncrements('user_id');
            $table->unsignedSmallInteger('createur_id')->nullable();
            $table->unsignedSmallInteger('user_vue_id')->nullable();
            $table->unsignedTinyInteger('user_type_id')->nullable();
            $table->string('user_num', 20)->nullable();
            $table->unsignedTinyInteger('user_civilite')->nullable();
            $table->string('user_nom', 63);
            $table->string('user_prenom', 63);
            $table->string('user_login', 63)->unique();
            $table->string('user_tel', 20)->nullable();
            $table->string('user_tel_port', 20)->nullable();
            $table->string('user_mel', 127)->nullable();
            $table->string('user_fax', 20)->nullable();
            $table->string('user_adresse', 127)->nullable();
            $table->string('user_adresse_bis', 127)->nullable();
            $table->string('user_cp', 10)->nullable();
            $table->string('user_commune', 63)->nullable();
            $table->string('user_bp', 10)->nullable();
            $table->string('user_pass', 255)->nullable();
            $table->string('user_pass_hash', 255)->nullable();
            $table->unsignedTinyInteger('user_cb_mode')->nullable();
            $table->unsignedTinyInteger('user_cb_multi')->nullable();
            $table->unsignedTinyInteger('user_cb_redir')->nullable();
            $table->unsignedTinyInteger('user_cb_force_mdp')->nullable();
            $table->dateTime('ctime')->nullable();
            $table->timestamp('utime')->nullable();
            $table->unsignedTinyInteger('actif')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sw_user');
    }
};
