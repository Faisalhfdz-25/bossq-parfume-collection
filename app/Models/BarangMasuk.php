<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model
{
    use HasFactory;
    protected $table = 'barang_masuk';
    protected $fillable = [
        'products_id',
        'suppliers_id',
        'qty',
        'tanggal',
        'harga_per_unit',
        'total_harga',
        'catatan'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'products_id');
    }
}
