<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesItem extends Model
{
    use HasFactory;

    protected $table = 'sales_items'; // Nama tabel

    protected $fillable = [
        'sale_id',      // Relasi ke tabel sales
        'product_id',   // Relasi ke tabel products
        'quantity',     // Jumlah barang
        'subtotal',     // Total harga per item (quantity x harga)
    ];

    protected $casts = [
        'quantity' => 'integer',
        'subtotal' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relasi dengan Sale (satu item terkait ke satu penjualan)
    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    // Relasi dengan Product (satu item terkait ke satu produk)
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Accessor: Format subtotal menjadi string dengan format rupiah
    public function getSubtotalAttribute($value)
    {
        return 'Rp ' . number_format($value, 0, ',', '.');
    }

    // Mutator: Hilangkan format rupiah sebelum menyimpan subtotal
    public function setSubtotalAttribute($value)
    {
        $this->attributes['subtotal'] = str_replace(['Rp', '.', ','], '', $value);
    }
}
