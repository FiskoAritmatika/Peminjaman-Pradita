<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('unit_kegiatan', function (Blueprint $table) {
            $table->id('id_unit');
            $table->string('nama_unit');
        });

        Schema::create('users', function (Blueprint $table) {
            $table->id('id_user');
            $table->string('nama_user');
            $table->string('password');
            $table->enum('role', ['Admin', 'Organisasi', 'Mahasiswa']);
            $table->unsignedBigInteger('id_unit')->nullable();
            $table->foreign('id_unit')->references('id_unit')->on('unit_kegiatan');
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('users');
        Schema::dropIfExists('unit_kegiatan');
    }
};
