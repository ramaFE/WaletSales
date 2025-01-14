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
}
