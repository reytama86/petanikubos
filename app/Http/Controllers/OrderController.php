<?php

namespace App\Http\Controllers;

use App\Models\transaksi_total;
use App\Models\transaksi_detail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['list','dikonfirmasi_list','dikemas_list','dikirim_list','diterima_list','selesai_list']);
        $this->middleware('api')->only(['store','update','destroy','ubah_status','baru','dikonfirmasi','dikemas','dikirim','diterima','selesai']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders=transaksi_total::with('member')->get();
        return response()->json([
            'data' => $orders
        ]);
    }

    public function list()
    {
        return view('pesanan.index');
    }

    public function dikonfirmasi_list()
    {
        return view('pesanan.dikonfirmasi');
    }

    public function dikirim_list()
    {
        return view('pesanan.dikirim');
    }

    public function diterima_list()
    {
        return view('pesanan.diterima');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_user' => 'required',
        ]);
        if($validator->fails()) {
            return response()->json(
                $validator->errors(),
                422
            );
        
        }
        $input = $request->all();
        $Order = transaksi_total::create($input);

        for($i = 0; $i < count($input['id_produk']); $i++){
            transaksi_detail::create([
                'id_order' => $Order['id_tt'],
                'id_produk' => $input['id_produk'][$i],
                'jumlah' => $input['jumlah'][$i],
                'harga' => $input['total'][$i],
            ]);
        }
        return response() -> json([
            'data' => $Order
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\transaksi_total  $Order
     * @return \Illuminate\Http\Response
     */
    public function show(transaksi_total $Order)
    {
        return response()->json([
            'data' => $Order
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\transaksi_total  $Order
     * @return \Illuminate\Http\Response
     */
    public function edit(transaksi_total $Order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\transaksi_total  $Order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, transaksi_total $Order)
    {
        $validator = Validator::make($request->all(), [
            'id_user' => 'required',
            
        ]);
        if($validator->fails()) {
            return response()->json(
                $validator->errors(),
                422
            );
        
        }
        $input = $request->all();
        $Order = transaksi_total::create($input);
        
        $Order->update($input);

        for($i = 0; $i < count($input['id_produk']); $i++){
            transaksi_detail::create([
                'id_order' => $Order['id_tt'],
                'id_produk' => $input['id_produk'][$i],
                'jumlah' => $input['jumlah'][$i],
                'harga' => $input['total'][$i],
            ]);
        }
        return response() -> json([
            'message' => 'success',
            'data' => $Order
        ]);
    }
    public function ubah_status(Request $request,transaksi_total $order)
    {
        $order->update([
           'status' => $request->status 
        ]);

        return response() -> json([
            'message' => 'success',
            'data' => $order
        ]);
    }

    public function dikonfirmasi()
    {
        $orders = transaksi_total::with('member')->where('status', 'konfirmasi')->get();
        return response()->json([
            'data' =>  $orders
        ]);
    }
    public function dikirim()
    {
        $orders = transaksi_total::with('member')->where('status', 'dikirim')->get();
        return response()->json([
            'data' => $orders
        ]);
    }
    public function diterima()
    {
        $orders = transaksi_total::with('member')->where('status', 'diterima')->get();
        return response()->json([
            'data' => $orders
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\transaksi_total  $Order
     * @return \Illuminate\Http\Response
     */
    public function destroy(transaksi_total $Order)
    {
        
        $Order->delete();
        return response() -> json([
            'message' => 'success'
        ]);
    }
    
}
