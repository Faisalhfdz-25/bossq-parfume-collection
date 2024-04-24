<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandingPages extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'banner_image_url',
        'content',
        'product_price',
        'instagram_photo_url',
        'video_url',
        'single_photo_url',
    ];

    public function overviews()
    {
        return $this->hasMany(Overview::class);
    }

    public function productPhotos()
    {
        return $this->hasMany(ProductPhotos::class);
    }

    public function reviews()
    {
        return $this->hasMany(Reviews::class);
    }
}
