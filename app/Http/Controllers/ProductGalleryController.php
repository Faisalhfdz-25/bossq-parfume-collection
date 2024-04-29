<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductGallery;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class ProductGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $galleries = ProductGallery::query();

            return DataTables::of($galleries)
                ->addColumn('action', function ($gallery) {
                    return '
                        <button type="button" class="btn btn-warning btn-sm edit-gallery" data-toggle="modal" data-target="#editGalleryModal' . $gallery->id . '">
                            Edit
                        </button>
                        <form action="' . route('product-galleries.destroy', $gallery->id) . '" method="POST" class="d-inline">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="submit" class="btn btn-danger btn-sm delete-gallery" data-gallery-id="' . $gallery->id . '">Delete</button>
                        </form>
                    ';
                })
                ->addColumn('product_name', function ($gallery) {
                    return $gallery->product->name;
                })
                ->addColumn('image', function ($gallery) {
                    return '<img src="' . Storage::url($gallery->url) . '" alt="Gallery Image" style="max-width: 100px;">';
                })
                ->rawColumns(['action', 'image'])
                ->make();
        }

        $galleries = ProductGallery::with('product')->get();
        $products = Product::all(); 
        return view('pages.gallery.index', compact('galleries', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'products_id' => 'required|exists:products,id',
            'url' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $imagePath = $request->file('url')->store('public/product_galleries');

        ProductGallery::create([
            'products_id' => $request->products_id,
            'url' => basename($imagePath),
        ]);

        return redirect()->route('product-galleries.index')->with('success', 'Gallery created successfully!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductGallery $gallery)
    {
        $validator = Validator::make($request->all(), [
            'products_id' => 'required|exists:products,id',
            'url' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if ($request->hasFile('url')) {
            // Delete existing image file
            Storage::delete('public/product_galleries/' . $gallery->url);
            
            // Upload and store new image file
            $imagePath = $request->file('url')->store('public/product_galleries');
            $gallery->url = basename($imagePath);
        }

        $gallery->products_id = $request->products_id;
        $gallery->save();

        return redirect()->route('product-galleries.index')->with('success', 'Gallery updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductGallery $gallery)
    {
        // Delete the image file associated with the gallery
        Storage::delete('public/product_galleries/' . $gallery->url);

        $gallery->delete();

        // Redirect back to gallery index page with success message
        return redirect()->route('product-galleries.index')->with('success', 'Gallery deleted successfully!');
    }
}
