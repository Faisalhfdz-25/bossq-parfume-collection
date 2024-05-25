<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetailListBelanja;
use Illuminate\Support\Facades\DB;

class DetailKonfirmasiController extends Controller
{
    public function index ()
    {
        $data = DetailListBelanja::all();

        return view('pages.konfirmasi_belanja.detail', compact('data'));
    }

    public function updateStatus(Request $request)
    {
        $data = DetailListBelanja::find($request->id);
        DB::beginTransaction();

        
        try {
            $data->acc = $request->acc;
            if ($data->update()) {
                DB::commit();
                // return redirect('/konfirmasi-belanja/detail/')->with('Save', 'Status Berhasil Diubah');
            }else{
                DB::rollback();
                // return redirect('/konfirmasi-belanja/detail')->with('Error', 'Data Gagal Diajukan', 'error');
            }
        } catch (\Throwable $th) {
            DB::rollback();
            // return redirect('/konfirmasi-belanja/detail/')->with('Error', 'Terjadi kesalahan: ' . $th->getMessage());
        }

        return redirect('/detail-konfirmasi')->with('Save', 'Status Berhasil Diubah');
    }
}
