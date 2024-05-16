<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function list()
    {
        return view('kategori.index');
    }

    public function index()
    {
        $categories = Kategori::all();
        return response()->json([
            'data' => $categories
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_kategori' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(
                $validator->errors(),
                422
            );
        }

        $category = Kategori::create($request->all());

        return response()->json([
            'success' => true,
            'data' => $category
        ]);
    }

    public function show($id_kategori)
    {
        $category = Kategori::findOrFail($id_kategori);
        return response()->json([
            'data' => $category
        ]);
    }

    public function update(Request $request, $id_kategori)
    {
        $validator = Validator::make($request->all(), [
            'nama_kategori' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(
                $validator->errors(),
                422
            );
        }

        $category = Kategori::find($id_kategori);
        $category->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil diperbarui',
            'data' => $category,
        ]);
    }

    public function destroy($id_kategori)
    {
        $category = Kategori::findOrFail($id_kategori);
        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus',
        ]);
    }
}
