<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Supplier;
use App\Models\ListBelanja;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\DetailListBelanja;
use Illuminate\Support\Facades\DB;

class ListBelanjaController extends Controller
{
    public function index ()
    {
        $tglSekarang = Carbon::now('Asia/Jakarta')->format('dmy');

        $lastList = ListBelanja::where('kode', 'LIKE', 'INV-LB-' . $tglSekarang . '%')
        ->orderBy('kode', 'desc')
        ->first();

        if ($lastList) {
            $lastNumber = (int)substr($lastList->kode, -2);
            $newNumber = str_pad($lastNumber + 1, 2, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '01';
        }

        $kode = 'INV-LB-' . $tglSekarang . $newNumber;

        $data = ListBelanja::all();
        $products = Product::where('stock', '<', 5)->get();
        $tempat = Supplier::orderBy('id', 'ASC')->get();
        $tgl = Carbon::now('Asia/Jakarta')->format('d-m-Y');
        $total = DetailListBelanja::where('kode', $kode )->sum('sub_total');

        $detail = DetailListBelanja::where('kode', $kode )->get();

        return view('pages.list_belanja.index', compact('data', 'kode', 'tgl', 'detail', 'total','products', 'tempat'));
    }

    public function simpan(Request $request)
    {

        
        $data = new DetailListBelanja();
        DB::beginTransaction();
        try {
            $data->kode = $request->kode;
            $data->products_id = $request->products_id;
            $data->harga = $request->harga;
            $data->tempat = $request->tempat;
            $data->qty = $request->qty;
            $data->sub_total = $request->sub_total;
            $data->acc = 0;


            if ($data->save()) {
                DB::commit();
                return redirect('/list-belanja')->with('Save', 'Data Berhasil Disimpan');
            } else {
                DB::rollback();
                return redirect('/list-belanja')->with('Error', 'Data Gagal Disimpan');
            }
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect('/list-belanja')->with('Error', 'Terjadi kesalahan: ' . $th->getMessage());
        }
    }

    public function ajukan(Request $request)
{
    $data = new ListBelanja();
    DB::beginTransaction();
    try {
        $data->kode = $request->kode;
        $data->tanggal = Carbon::now('Asia/Jakarta');
        
        
        $totalItem = DetailListBelanja::count();
        $data->total_items = $totalItem;
        
        
        $data->total_payment = $request->total;

        if ($data->save()) {
            DB::commit();
            return redirect('/list-belanja')->with('Save', 'Data Berhasil Diajukan');
        } else {
            DB::rollback();
            return redirect('/list-belanja')->with('Error', 'Data Gagal Diajukan');
        }
    } catch (\Throwable $th) {
        DB::rollback();
        return redirect('/list-belanja')->with('Error', 'Terjadi kesalahan: ' . $th->getMessage());
    }
}
}
