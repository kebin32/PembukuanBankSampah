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
    Schema::create('setoran_details', function (Blueprint $table) {
        $table->id();
        // Remove setoran_id foreign key as we will not use Setoran table
        // $table->foreignId('setoran_id')->constrained('setorans')->onDelete('cascade');
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        $table->string('nama');
        $table->foreignId('daftar_id')->constrained('daftars')->onDelete('cascade');
        $table->integer('satuan');
        $table->decimal('harga', 10, 2);
        $table->decimal('subtotal', 10, 2);
        $table->decimal('total', 10, 2);
        $table->dateTime('tanggal_transaksi');
        $table->timestamps();
    });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('setoran_details');
    }
};
