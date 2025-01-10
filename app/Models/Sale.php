<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $table = 'sales'; // Nama tabel

    protected $fillable = [
        'delivery_order',
        'customer_id', // Relasi ke tabel customers
        'total',       // Total dari penjualan
    ];

    protected $casts = [
        'total' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relasi dengan Customer (satu penjualan memiliki satu customer)
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Relasi dengan SalesItem (satu penjualan memiliki banyak item)
    public function items()
    {
        return $this->hasMany(SalesItem::class);
    }

    // Accessor: Format total menjadi string dengan format rupiah
    public function getTotalAttribute($value)
    {
        return 'Rp ' . number_format($value, 0, ',', '.');
    }

    // Mutator: Hilangkan format rupiah sebelum menyimpan total
    public function setTotalAttribute($value)
    {
        $this->attributes['total'] = str_replace(['Rp', '.', ','], '', $value);
    }
}
