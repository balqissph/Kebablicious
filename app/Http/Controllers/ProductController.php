<?php

namespace App\Http\Controllers;

use App\Models\product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Store a newly created product in the database.
     */

    public function tampildata()
    {
        $posts = product::paginate(5);

        return view('admin.admin-dashboard-manage-menu', compact('posts'));
    }


    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|integer',
            'deskripsi' => 'nullable|String',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Proses upload gambar jika ada
        $image = null;
        if ($request->hasFile('gambar')) {
            $image = $request->file('gambar')->store('product_images', 'public');
        }

        // Simpan produk ke database
        Product::create([
            'nama' => $request->nama,
            'harga' => $request->harga,
            'deskripsi' => $request->deskripsi,
            'gambar' => $image,
        ]);

        // Redirect kembali dengan pesan sukses
        return redirect()->route('menu');
    }

    public function hapusdata($id)
    {

        $product = product::findOrFail($id);

        if ($product) {
            $product->delete();
        }

        return redirect()->route('menu');
    }

    public function editdata(Request $request, $id)
    {
        $data = product::findOrFail($id);


    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|integer',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Temukan produk berdasarkan ID
        $product = product::findOrFail($id); 

        // Update atribut produk
        $product->nama = $request->input('nama');
        $product->harga = $request->input('harga');
        $product->deskripsi = $request->input('deskripsi');

        // Cek apakah ada gambar baru yang diunggah
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($product->gambar) {
                Storage::delete($product->gambar);
            }

            // Simpan gambar baru dan ambil path-nya
            $path = $request->file('gambar')->store('images/products', 'public');
            $product->gambar = $path;
        }

        // Simpan perubahan ke database
        $product->save();

        // Redirect dengan pesan sukses
        return redirect()->route('menu')->with('success', 'Produk berhasil diperbarui.');
    }
}