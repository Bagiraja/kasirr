<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    //
    public function dashboard()
    {
        return view('barang.dashboard');
    }
    
    public function index()
    {
        $products = Barang::all();
        return view('barang.products.index', compact('products'));
    }

    public function create()
    {
        return view('barang.products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_barang' => 'required|unique:products,kode_barang',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        Barang::create([
            'kode_barang' => $request->kode_barang,
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
        ]);

        return redirect()->route('barang.products')->with('success', 'Product created successfully');
    }

    public function edit($id)
    {
        $product = Barang::findOrFail($id);
        return view('barang.products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $product = Barang::findOrFail($id);
    
        $request->validate([
            'kode_barang' => 'required|unique:products,kode_barang,' . $product->id,
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
        ]);
    
        $product->update([
            'kode_barang' => $request->kode_barang,
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
        ]);
    
        return redirect()->route('barang.products')->with('success', 'Product updated successfully');
    }
    

    public function destroy($id)
    {
        $product = Barang::findOrFail($id);
        $product->delete();

        return redirect()->route('barang.products')->with('success', 'Product deleted successfully');
    }

    public function search(Request $request){
           $keyword = $request->input('cari');
           $barang = Barang::where('nama_barang','like',"%".$keyword."%")->paginate(2);

           return view('barang.produck', compact('barang'));
    }
}
