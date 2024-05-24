<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Models\ProductGallery;
use App\Models\Supplier; // Pastikan Anda telah menambahkan model Supplier
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = Product::query();

            return DataTables::of($query)
                ->addColumn('action', function ($product) {
                    return '
                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editProductModal' . $product->id . '">
                            Edit
                        </button>
                        <form action="' . route('products.destroy', $product->id) . '" method="POST" class="d-inline">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="submit" class="btn btn-danger btn-sm delete-product" data-product-id="' . $product->id . '">Delete</button>
                        </form>
                    ';
                })
                ->rawColumns(['action'])
                ->make();
        }

        $products = Product::with('category', 'supplier')->get(); // Menambahkan relasi supplier
        $categories = ProductCategory::all();
        $suppliers = Supplier::all(); // Menyediakan data supplier untuk view
        return view('pages.products.index', compact('products', 'categories', 'suppliers'));
    }

    public function show(Product $product)
    {
        // Ambil semua galeri terkait dengan produk
        $galleries = ProductGallery::where('products_id', $product->id)->get();

        return view('pages.products.detail', compact('product', 'galleries'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'categories_id' => 'required',
            'supplier_id' => 'required|exists:suppliers,id',
            'harga_modal' =>'required' ,
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0', // Menambahkan validasi stock
            'status' => 'required', // Menambahkan validasi status
            'description' => 'nullable|string',
            'tags' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        Product::create($request->all());

        return redirect()->route('products.index')->with('success', 'Product created successfully!');
    }

    public function update(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'categories_id' => 'required',
            'supplier_id' => 'required|exists:suppliers,id', // Menambahkan validasi supplier_id
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0', // Menambahkan validasi stock
            'status' => 'required', // Menambahkan validasi status
            'description' => 'nullable|string',
            'tags' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $product->update($request->all());

        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        // Redirect back to product index page with success message
        return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
    }
}
