<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $suppliers = Supplier::query();

            return DataTables::of($suppliers)
                ->addColumn('action', function ($supplier){
                    return '
                        <button type="button" class="btn btn-warning btn-sm edit-supplier" data-toggle="modal" data-target="#editSupplierModal' . $supplier->id . '">
                            Edit
                        </button>
                        <form action="' . route('suppliers.destroy', $supplier->id) . '" method="POST" class="d-inline">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="submit" class="btn btn-danger btn-sm delete-supplier" data-supplier-id="' . $supplier->id . '">Delete</button>
                        </form>
                    ';
                })
                ->rawColumns(['actiom'])
                ->make();
        }

        $suppliers = Supplier::all();
        return view('pages.supplier.index', compact('suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'address' => 'required|string',
            'email' => 'required|string|email|unique:suppliers',
            'phone' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        Supplier::create($request->all());

        return redirect()->route('suppliers.index')->with('success', 'Supplier Berhasil di tambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supplier $supplier)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'address' => 'required|string',
            'email' => 'required|string|email|unique:suppliers,email,' . $supplier->id,
            'phone' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $supplier->update($request->all());

        return redirect()->route('suppliers.index')->with('success', 'Data Supplier berhasil di edit');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        return redirect()->route('suppliers.index')->with('success', 'Data Supplier berhasil dihapus');
    }
}
