<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\Product;
use App\Models\ListBelanja;
use Illuminate\Http\Request;
use App\Models\DetailListBelanja;
use Illuminate\Support\Facades\DB;


class KonfirmasiBelanjaController extends Controller
{

    public function index()
    {
            $data = ListBelanja::all();

        return view('pages.konfirmasi_belanja.index', compact('data'));
    }

    public function getDetails($kode)
    {
        $details = DetailListBelanja::where('kode', $kode)->with('products')->get();
        return response()->json($details);
    }

    public function update(Request $request)
    {
        $detail = DetailListBelanja::find($request->id);
        DB::beginTransaction();
        try {
            $detail->acc = $request->acc;

            if ($detail->update()) {
                DB::commit();
                return response()->json(['success' => true]);
            } else {
                DB::rollback();
                return response()->json(['success' => false]);
            }
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $th->getMessage()]);
        }
    }

    public function print($kode)
    {
        $listBelanja = ListBelanja::where('kode', $kode)->firstOrFail();
        $details = DetailListBelanja::where('kode', $listBelanja->kode)->get();

        $data = [
            'listBelanja' => $listBelanja,
            'details' => $details
        ];

        return view('pages.konfirmasi_belanja.print', $data);
    }

    public function printPdf($kode)
    {
        $listBelanja = ListBelanja::where('kode', $kode)->firstOrFail();
        $details = DetailListBelanja::where('kode', $listBelanja->kode)->get();

        $data = [
            'listBelanja' => $listBelanja,
            'details' => $details
        ];

        $html = view('pages.konfirmasi_belanja.print', $data)->render();

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $dompdf->stream($kode . '.pdf', ['Attachment' => false]);
    }
}
