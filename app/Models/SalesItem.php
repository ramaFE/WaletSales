<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesItem extends Model
{
    use HasFactory;

    protected $table = 'sales_items'; // Nama tabel

    protected $fillable = [
        'sales_id',     // Relasi ke tabel sales
        'kode_produk',  // Kode produk
        'nama_barang',  // Nama barang
        'berat',        // Berat barang
        'harga',        // Harga barang
        'subtotal',     // Total harga per item (berat x harga)
    ];

    // Relasi dengan Sale (satu item terkait ke satu penjualan)
    public function sale()
    {
        return $this->belongsTo(Sale::class, 'sales_id');
    }
}
