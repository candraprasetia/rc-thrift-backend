<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index() {
        return response()->json(Product::query()->latest()->get());
    }

    public function store(Request $request) {
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $product = Product::query()->create([
            'name' => $request->name,
            'price' => $request->price,
            'description' => 'Baju thrift',
            'category' => $request->category,
            'image' => $imagePath,
        ]);
        return response()->json($product, 201);
    }

    // FUNGSI BARU UNTUK EDIT PRODUK
    public function update(Request $request, $id) {
        $product = Product::query()->findOrFail($id);
        $product->name = $request->name;
        $product->price = $request->price;
        $product->category = $request->category;

        // Jika admin mengupload gambar baru saat edit
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $product->image = $request->file('image')->store('products', 'public');
        }

        $product->save();
        return response()->json($product);
    }

    public function destroy($id) {
        $product = Product::query()->findOrFail($id);
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();
        return response()->json(['message' => 'Deleted']);
    }
}
