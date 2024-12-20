<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;
use App\Models\product;
use Illuminate\Support\Facades\Storage;


class apiProductController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api'); // Pastikan pengguna sudah terautentikasi
        $this->middleware('role:admin')->only(['store', 'update', 'destroy']); // Hanya admin yang bisa CRUD produk
    }
    public function index()
    {

        return ProductResource::collection(product::paginate(2));

    }

    public function show($id)
    {
        $product = product::find($id);

        if (!$product) {
            return response()->json(['pesan' => 'produk tidak ditemukan']);
        }

        return response()->json($product);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|integer',
            'deskripsi' => 'nullable|String',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product = product::create($validated);

        return response()->json(['pesan' => 'produk berhasil ditambah', 'data' => $product], 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|integer',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product = product::findOrFail($id);

        $product->nama = $request->input('nama');
        $product->harga = $request->input('harga');
        $product->deskripsi = $request->input('deskripsi');

        if ($request->hasFile('gambar')) {
            if ($product->gambar) {
                Storage::delete($product->gambar);
            }
            $path = $request->file('gambar')->store('images/products', 'public');
            $product->gambar = $path;
        }

        $product->save();
        return response()->json(['pesan' => 'produk berhasil diperbaharui']);
    }

    public function destroy($id)
    {
        $product = product::find($id);

        if (!$product) {

            return response()->json(['pesan' => 'prduk tidak ditemukan']);

        }

        $product->delete();

        return response()->json(['pesan' => 'produk berhasil dihapus']);
    }
}
