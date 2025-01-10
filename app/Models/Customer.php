<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customers'; // Nama tabel (opsional, jika berbeda)

    protected $fillable = [
        'code',
        'name',
        'contact',
        'address',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relasi dengan model Sale
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    // Accessor: Ubah nama customer menjadi huruf kapital saat diambil
    public function getNameAttribute($value)
    {
        return strtoupper($value);
    }

    // Mutator: Ubah nama customer menjadi huruf kecil sebelum disimpan
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtolower($value);
    }
}

