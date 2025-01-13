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
        'subtotal',    // Subtotal dari penjualan
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
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
        return $this->hasMany(SalesItem::class, 'sales_id');
    }

    public function getSubtotalAttribute()
    {
        return $this->items->sum('total'); // Ganti 'total' dengan nama kolom subtotal di tabel sales_items
    }

}
