<?php

namespace App\Http\Controllers;

use App\Models\BarangMasuk;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BarangMasukController extends Controller
{
    public function index()
    {
        $data = BarangMasuk::with('product')->get();
        $products = Product::all();
        $tanggal = Carbon::now('Asia/Jakarta')->format('Y-m-d');
        $supplier = Supplier::all();
        return view('pages.barang_masuk.index', compact('data', 'products', 'tanggal', 'supplier'));
    }

    public function simpan (Request $request)
    {
        Log::info($request->all());
        
        $data = new BarangMasuk();
        DB::beginTransaction();
        try {
            $data->tanggal = $request->tanggal;
            $data->products_id = $request->products_id;
            $data->suppliers_id = $request->suppliers_id;
            $data->qty = $request->qty;
            $data->harga_per_unit = $request->harga_per_unit;
            $data->total_harga = $request->total_harga;
            $data->catatan = $request->catatan;
            Log::info('Data BarangMasuk:', $data->toArray());


            if ($data->save()) {
                $product = Product::find($request->products_id);
                if ($product) {
                    $product->stock + $request->qty; 
    
                    
                    if ($product->harga_modal != $request->harga_per_unit) {
                        $product->harga_modal = $request->harga_per_unit;
                    }
    
                    Log::info('Produk Update:', $product->toArray());
                    if ($product->save()) {
                        DB::commit();
                        return redirect('/barang-masuk')->with('Save', 'Data Berhasil Disimpan');
                    } else {
                        DB::rollback();
                        return redirect('/barang-masuk')->with('Error', 'Data Produk Gagal di Update');
                    }
                } else {
                    DB::rollback();
                    return redirect('/barang-masuk')->with('Error', 'Produk tidak ditemukan');
                }
            } else {
                DB::rollback();
                return redirect('/barang-masuk')->with('Error', 'Data Gagal di Simpan');
            }
        } catch (\Throwable $th) {
            DB::rollback();
            Log::error('Error saving BarangMasuk:', ['message' => $th->getMessage()]);
            return redirect('/barang-masuk')->with('Error', 'Terjadi kesalahan: ' . $th->getMessage());
        }
        
    }
}
