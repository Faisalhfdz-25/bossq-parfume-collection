<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListBelanja extends Model
{
    use HasFactory;
    protected $table = 'list_belanja';

    public function detailListBelanja()
    {
        return $this->hasMany(DetailListBelanja::class, 'id');
    }
}
