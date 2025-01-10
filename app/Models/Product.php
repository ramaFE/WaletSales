<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'products';

    // Kolom yang dapat diisi secara massal
    protected $fillable = [
        'kode_produk',
        'nama_barang',
        'berat',
        'harga',
        'total', // Tambahkan kolom total
    ];

    // Tipe data untuk casting
    protected $casts = [
        'berat' => 'integer',
        'harga' => 'decimal:2',
        'total' => 'integer', // Pastikan kolom total disimpan sebagai integer
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relasi dengan SalesItem (satu produk bisa muncul di banyak item penjualan)
    public function salesItems()
    {
        return $this->hasMany(SalesItem::class);
    }

    // Accessor: Mengubah nama barang menjadi huruf kapital saat diambil
    public function getNamaBarangAttribute($value)
    {
        return strtoupper($value);
    }

    // Mutator: Mengubah nama barang menjadi huruf kecil sebelum disimpan
    public function setNamaBarangAttribute($value)
    {
        $this->attributes['nama_barang'] = strtolower($value);
    }

    // Accessor untuk total (jika Anda ingin menghitung total secara dinamis)
    public function getTotalAttribute()
    {
        if (isset($this->attributes['berat']) && isset($this->attributes['harga'])) {
            return $this->attributes['berat'] * $this->attributes['harga'];
        }
        return 0; // Jika data tidak lengkap, kembalikan 0
    }

    // Mutator untuk menyimpan total ke database
    public function setTotalAttribute($value)
    {
        // Pastikan total dihitung dari berat * harga
        $this->attributes['total'] = $this->attributes['berat'] * $this->attributes['harga'];
    }
}
