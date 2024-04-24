<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;

class ProductCategoryController extends Controller
{
    public function all(Request $request)
    {
        $id = $request->input('id');
        $limit = $request->input('limit');
        $name = $request->input('name');

        $show_product = $request->input('show_product');

        if ($id) {
            $category = ProductCategory::with(['products'])->find($id);

            if ($category) {
                return ResponseFormatter::success(
                    $category,
                    'Data Kategori Berhasil di ambil'
                );
            }else {
                return ResponseFormatter::error(
                    null,
                    'Data Kategori tidak ada',
                    404
                );
            }
        }
        $category = ProductCategory::query();

        if ($name) {
            $category->where('name','like','%' . $name . '%');
        }
        if ($show_product) {
            $category->with('products');
        }
        return ResponseFormatter::success(
            $category->paginate($limit),
            'Data List Kategori Berhasil di ambil'
        );
    }
}
