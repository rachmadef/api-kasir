<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('user')) {
            Schema::create('user', function (Blueprint $table) {
                $table->increments('id_user');
                $table->string('nama', 100);
                $table->string('email', 100)->unique();
                $table->string('password', 255);
                $table->string('no_telp', 20)->nullable();
                $table->enum('role', ['Admin', 'Karyawan']);
                $table->enum('status', ['Aktif', 'Tidak Aktif'])->default('Aktif');
                $table->timestamps();
            });
        }
    }


    public function down(): void
    {
        Schema::dropIfExists('user');
    }
};
