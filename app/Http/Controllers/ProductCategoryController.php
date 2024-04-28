<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductCategory;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $categories = ProductCategory::query();

            return DataTables::of($categories)
                ->addColumn('action', function ($category) {
                    return '
                        <button type="button" class="btn btn-warning btn-sm edit-category" data-toggle="modal" data-target="#editCategoryModal' . $category->id . '">
                            Edit
                        </button>
                        <form action="' . route('categories.destroy', $category->id) . '" method="POST" class="d-inline">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="submit" class="btn btn-danger btn-sm delete-category" data-category-id="' . $category->id . '">Delete</button>
                        </form>
                    ';
                })
                ->addColumn('image', function ($category) {
                    return '<img src="' . asset('storage/category_image/' . $category->url) . '" alt="' . $category->name . '" style="max-width: 100px;">';
                })
                ->rawColumns(['action', 'image'])
                ->make();
        }

        $categories = ProductCategory::all();
        return view('pages.category.index', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'url' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $imagePath = $request->file('url')->store('public/category_image');
        $imageUrl = Storage::url($imagePath);

        ProductCategory::create([
            'name' => $request->name,
            'url' => $imagePath,
        ]);

        return redirect()->route('categories.index')->with('success', 'Category created successfully!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductCategory $category)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'url' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if ($request->hasFile('url')) {
            // Delete existing image file
            Storage::delete($category->url);
            
            // Upload and store new image file
            $imagePath = $request->file('url')->store('public/category_image');
            $category->url = $imagePath;
        }

        $category->name = $request->name;
        $category->save();

        return redirect()->route('categories.index')->with('success', 'Category updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductCategory $category)
    {
        $category->delete();

        // Delete the image file associated with the category
        Storage::delete($category->url);

        // Redirect back to category index page with success message
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully!');
    }
}
