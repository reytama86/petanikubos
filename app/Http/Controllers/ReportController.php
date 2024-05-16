<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderDetail;

class ReportController extends Controller
{public function get_reports(Request $request)
    {
       $report = DB::table('transaksi_detail')
       ->join('produk', 'produk.id_produk', '=', 'transaksi_detail.id_produk')
       ->select(DB::raw('
            produk.nama_produk,
            count(*) as jumlah_dibeli, 
            produk.harga,
            SUM(transaksi_detail.jumlah) as total_qty,
            SUM(produk.harga * transaksi_detail.jumlah) as pendapatan'))
        ->whereRaw("date(transaksi_detail.created_at) >= '$request->dari'")
        ->whereRaw("date(transaksi_detail.created_at) <= '$request->sampai'")
        ->groupBy('transaksi_detail.id_produk', 'produk.nama_produk', 'produk.harga')
        ->get();
    
       return response()->json([
        'data' => $report
       ]);
    }
    


    public function index()
    {
        return view('report.index');
    }
}
