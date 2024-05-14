<?php

namespace App\Http\Controllers;


use App\Models\Category;
use App\Models\Kategori;
use App\Models\Produk;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['list']);
        $this->middleware('api')->only(['store','update','destroy']);
    }
    public function list()
    {
        $categories = Kategori::all();
        return view('product.index', compact('categories'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products=Produk::with('category')->get();
        return response()->json([
            'success' => true,
            'data' => $products
        ]);
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
            'nama_produk'=> 'required',
            'harga'=> 'required',
            'deskripsi' => 'required',
            'id_kategori'=> 'required',
        ]);
        if($validator->fails()) {
            return response()->json(
                $validator->errors(),
                422
            );
        
        }
        $input = $request->all();
        $Product = Produk::create($input);
        return response() -> json([
            'success' => true,
            'data' => $Product
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Produk  $Product
     * @return \Illuminate\Http\Response
     */
    public function show(Produk $Product)
    {
        return response()->json([
            'success' => true,
            'data' => $Product
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Produk  $Product
     * @return \Illuminate\Http\Response
     */
    public function edit(Produk $Product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Produk  $Product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Produk $Product)
    {
        $validator = Validator::make($request->all(), [
            'nama_produk'=> 'required',
            'harga'=> 'required',
            'deskripsi' => 'required',
            'id_kategori'=> 'required',
        ]);
        if($validator->fails()) {
            return response()->json(
                $validator->errors(),
                422
            );
        
        }
        $input = $request->all();
        $Product->update($input);
        return response() -> json([
            'success' => true,
            'message' => 'success',
            'data' => $Product
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Produk  $Product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Produk $Product)
    {
        $Product->delete();
        return response() -> json([
            'success' => true,
            'message' => 'success'
        ]);
    }
}
