<?php

namespace App\Http\Controllers;

use App\Models\transaksi_total;

use App\Models\Anggota;
use App\Models\Product;
use App\Models\Produk;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        // Menghitung jumlah data dari masing-masing model
        $totaltransaksi_totals = transaksi_total::count();
        $totalAnggota = Anggota::count();
        $totalProducts = Produk::count();

        // Menghitung jumlah pesanan untuk setiap status
        $totalPesananBaru = transaksi_total::where('status', 'Baru')->count();
        $totalPesananDikonfirmasi = transaksi_total::where('status', 'konfirmasi')->count();
        $totalPesananDikemas = transaksi_total::where('status', 'dikemas')->count();
        $totalPesananDikirim = transaksi_total::where('status', 'dikirim')->count();
        $totalPesananDiterima = transaksi_total::where('status', 'diterima')->count();
        $totalPesananSelesai = transaksi_total::where('status', 'Selesai')->count();

        // Mengirim semua data ke dashboard.blade.php
        return view('dashboard', [
            'totaltransaksi_totals' => $totaltransaksi_totals,
            'totalAnggota' => $totalAnggota,
            'totalProducts' => $totalProducts,
            'totalPesananBaru' => $totalPesananBaru,
            'totalPesananDikonfirmasi' => $totalPesananDikonfirmasi,
            'totalPesananDikemas' => $totalPesananDikemas,
            'totalPesananDikirim' => $totalPesananDikirim,
            'totalPesananDiterima' => $totalPesananDiterima,
            'totalPesananSelesai' => $totalPesananSelesai,
        ]);
    }
}
