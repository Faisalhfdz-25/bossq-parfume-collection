<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailListBelanja extends Model
{
    use HasFactory;
    protected $table = 'detail_list_belanja';

    public function products()
    {
        return $this->belongsTo(Product::class, 'products_id');
    }
}
