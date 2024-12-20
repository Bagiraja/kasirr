<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();

        $products  = Product::paginate(3);
        return view('admin.products.index', compact('products'));
    }

    
    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_barang' => 'required|unique:products,kode_barang',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'nullable|image|mimes:jpg.jpeg.png|max:2048',
        ]);

        $imagePath = null;
        if($request->hasFile('image')) {
            $image = $request->file('image')->store('images/products','public');
        }

        Product::create([
            'kode_barang' => $request->kode_barang,
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.products')->with('success', 'Product created successfully');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
    
        $request->validate([
            'kode_barang' => 'required|unique:products,kode_barang,' . $product->id,
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'nullable|image|mimes:jpg.jpeg.png|max:2048',
        ]);
        
        $imagePath = $product->image;
        if($request->hasFile('image')) {
        
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
        
        $imagePath = $request->file('image')->store('images/products', 'public');
        }
        
        $product->update([
            'kode_barang' => $request->kode_barang,
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $imagePath,
        ]);
    
        return redirect()->route('admin.products')->with('success', 'Product updated successfully');
    }
    

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('admin.products')->with('success', 'Product deleted successfully');
    }


    public function search(Request $request){
        $search = $request->input('search');

        $products = Product::query()
        ->where('name','LIKE', "%{$search}%")
        ->orWhere('kode_barang','LIKE', "%{$search}%")
        ->paginate(3);

    return view('admin.products.index', compact('products','search'));

    }

    public function stocksearch(Request $request){

        
    $search = $request->input('search');

    $stocks = Product::Where('name' ,'LIKE',"%{$search}%")->paginate(3);

    return view('admin.reports.stock',compact('stocks'));
    }

    public function downloadPDF()
{
    $transactions = Transaction::with('product')->get(); // Fetch all transactions

    // Pass the data to the PDF view
    $pdf = Pdf::loadView('admin.transactions.pdf', compact('transactions'));
    
    // Download the generated PDF
    return $pdf->download('transactions_report.pdf');
}
}