<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('kode_produk'); 
            $table->string('nama_barang');
            $table->integer('berat');
            $table->decimal('harga', 10, 2);
            $table->decimal('total', 15, 2);
            $table->timestamps();

            // Tambahkan unique constraint untuk kombinasi kode_produk dan nama_barang
            $table->unique(['kode_produk', 'nama_barang'], 'unique_kode_produk_nama_barang');
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
