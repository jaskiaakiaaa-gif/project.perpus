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
        Schema::create('member', function (Blueprint $table) {
            $table->id();
            $table->string('nama_member');
            $table->string('foto_member')->nullable();
            $table->text('email')->unique();
            $table->enum('jenis_kelamin',['Pria', 'Wanita']);
            $table->date('tanggal_lahir');
            $table->string('no_telepon');
           $table->string('nama_buku');
         $table->enum('status', ['Dipinjam', 'Dikembalikan'])->default('Dipinjam'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member');
    }
};
