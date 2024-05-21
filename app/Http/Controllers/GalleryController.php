<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductGallery;

class GalleryController extends Controller
{
    

    public function simpan(Request $request, Product $product)
    {
        

        // Handle image upload
        $imagePath = $request->file('url')->store('public/product_images');
        $imagePath = str_replace('public/', 'storage/', $imagePath); // Mengubah path sesuai dengan kebutuhan

        $gallery = ProductGallery::create([
            'products_id' => $product->id,
            'url' => $imagePath,
            
        ]);

        return redirect()->route('products.show');
    }
}