<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Product;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('product')->get();

        $transactions = Transaction::paginate(3);
        return view('admin.transactions.index', compact('transactions'));
    }

    public function create()
    {
        $products = Product::all();
        return view('admin.transactions.create', compact('products'));
    }

    public function store(Request $request)
{
    $request->validate([
        'product_id' => 'required|exists:products,id',
        'quantity' => 'required|integer|min:1',
        'price' => 'required|numeric',
        
    ]);

    $total = $request->quantity * $request->price;

    Transaction::create([
        'product_id' => $request->product_id,
        'quantity' => $request->quantity,
        'price' => $request->price,
        'total' => $total,
    ]);

    return redirect()->route('admin.transactions.index')->with('success', 'Transaction created successfully');
}


    public function show($id)
    {
        $transaction = Transaction::with('product')->findOrFail($id);
        return view('admin.transactions.show', compact('transaction'));
    }

    public function edit($id)
    {
        $transaction = Transaction::findOrFail($id);
        $products = Product::all();
        return view('admin.transactions.edit', compact('transaction', 'products'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric',
        ]);

        $transaction = Transaction::findOrFail($id);
        $total = $request->quantity * $request->price;

        $transaction->update([
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'total' => $total,
        ]);

        return redirect()->route('admin.transactions.index')->with('success', 'Transaction updated successfully');
    }

    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();

        return redirect()->route('admin.transactions.index')->with('success', 'Transaction deleted successfully');
    }

    public function searchtrx(Request $request)
{
    // Ambil input pencarian dari form
    $search = $request->input('search');
    
    // Lakukan pencarian pada transaksi yang terkait dengan produk
    $transactions = Transaction::with('product')
        ->whereHas('product', function($query) use ($search) {
            $query->where('name', 'LIKE', "%{$search}%");
        })->paginate(3);
        

    // Kembalikan hasil pencarian ke tampilan
    return view('admin.transactions.index', compact('transactions', 'search'));
}
}
